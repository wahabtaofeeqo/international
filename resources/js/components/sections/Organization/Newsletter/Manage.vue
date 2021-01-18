<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Newsletters<br>
				<div class="h6 mt-1 text-gray-500">Manage all your newsletters.</div>
			</h1>
		</div>

		<div class="card shadow mb-4"  v-if="newsletters.length > 0">
			<div class="table-responsive" v-show="!editSpace">
				<table class="table table-borderless table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Subject</th>
							<th>Target</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(newsletter, index) in newsletters">
							<td>{{ index+1 }}</td>
							<td>{{ newsletter.subject }}</td>
							<td>
								<div v-html="newsletter.target"></div>
							</td>
							<td>
								<span v-if="$parent.user.role.name === 'admin' || $parent.user.role.name === 'super'">
									<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#dispatchNewsletter" @click="selectNewsletter(newsletter)">Dispatch</button>
								</span>

								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#viewNewsletter" @click="viewNewsletter(newsletter)">View</button>
								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="deleteNewsletter(newsletter.id)">Delete</button>
								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" @click="editNewsletter(newsletter)">Edit</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div v-show="editSpace" ref="formContainer">
				<form class="user" @submit.prevent="update" @keydown="form.onKeydown($event)">
					<div class="card-header py-3">
						<div class="form-group">
							<label class="text-primary" for="subject"></label>
							<input type="text" name="subject" class="form-control form-control-user" id="subject" :class="{ 'is-invalid': form.errors.has('subject') }" placeholder="Mail subject..." v-model.trim="form.subject" required>
							<has-error :form="form" field="subject"></has-error>
						</div>
					</div>
					<div class="card-body">
							<div class="form-group">
								<tinymce id="d1" v-model="form.content"></tinymce>
							</div>

							<div class="row">
								<div class="col-lg-3 mb-3">
									<button type="button" class="btn btn-secondary btn-user btn-block" @click="editSpace = false">Cancel</button>
								</div>
								<div class="col-lg-3 mb-3">
									<button type="submit" class="btn btn-primary btn-user btn-block">Update</button>
								</div>
								<div class="col-lg-3 mb-3">
									<button type="button" class="btn btn-success btn-user btn-block" @click="updateAndTest">Update and Test</button>
								</div>
								<div class="col-lg-3">
									<button type="button" class="btn btn-warning btn-user btn-block" @click="test">Just Test</button>
								</div>
							</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card border-left-primary shadow h-100 py-2" v-else>
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Newsletters</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">There are no newsletters at the moment</div>
					</div>
				</div>
			</div>
		</div>

		<!-- View Newsletter -->
		<div class="modal fade" id="viewNewsletter" tabindex="-1" role="dialog" aria-labelledby="newsletterModal" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-primary" id="newsletterModal">
							Newsletter: <b>{{ selectedNewsletter.subject }}</b>
						</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fas fa-times"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<div v-html="selectedNewsletter.content"></div>
					</div>
				</div>
			</div>
		</div>

		<!-- Dispatch Newsletter -->
		<div class="modal fade" id="dispatchNewsletter" tabindex="-1" role="dialog" aria-labelledby="dispatchNewsletterModal" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-primary" id="dispatchNewsletterModal">
							Newsletter: <b>{{ selectedNewsletter.subject }}</b>
						</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fas fa-times"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<form class="user" @submit.prevent="dispatch" @keydown="dispatchForm.onKeydown($event)">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Who do you want to target?</div>

							<!-- Members -->
							<div class="card border-left-primary shadow h-100 py-2 mb-3" v-if="membersChoiceParent">
								<div class="card-body">
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="membersCheck" v-model="dispatchForm.members.select">
											<label class="custom-control-label" for="membersCheck">Members</label>
										</div>
									</div>

									<div class="ml-4 form-group" v-show="membersChoice">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Select the language you want to send to</div>

										<div class="form-inline mb-4">
											<div class="custom-control custom-radio mr-3">
												<input type="radio" name="memberLanguage" class="custom-control-input" id="memberLanguageAll" value="0" v-model="dispatchForm.members.language">
												<label class="custom-control-label" for="memberLanguageAll">All</label>
											</div>
											<div class="custom-control custom-radio mr-3" v-for="language in membersLanguages">
												<input type="radio" name="memberLanguage" class="custom-control-input" :id="'memberLanguage'+language.id" :value="language.id" v-model="dispatchForm.members.language">
												<label class="custom-control-label" :for="'memberLanguage'+language.id">{{ language.name }}</label>
											</div>
										</div>

										<div class="text-xs font-weight-bold text-primary text-uppercase">Select the cities you want to send to</div>

										<div class="form-inline">
											<div class="custom-control custom-checkbox mr-3" v-for="city in membersCities">
												<input type="checkbox" class="custom-control-input" :id="'memberRegion'+city.id" :value="city.id" v-model="dispatchForm.members.cities">
												<label class="custom-control-label" :for="'memberRegion'+city.id">{{ city.name }}</label>
											</div>
										</div>

										<div class="small text-info">Do not check any city if you want target ALL cities.</div>
									</div>
								</div>
							</div>
							<div v-else>
								<div class="alert alert-warning">
									You have no members at the moment.
								</div>
							</div>

							<!-- Subscribers -->
							<div class="card border-left-primary shadow h-100 py-2 mb-3" v-if="subscribersChoiceParent">
								<div class="card-body">
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="subscribersCheck" v-model="dispatchForm.subscribers.select">
											<label class="custom-control-label" for="subscribersCheck">Subscribers</label>
										</div>
									</div>

									<div class="ml-4 form-group" v-show="subscribersChoice">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Select a specific language</div>

										<div class="form-inline">
											<div class="custom-control custom-radio mr-3">
												<input type="radio" name="subscriberLanguage" class="custom-control-input" id="subscriberLanguageAll" value="0" v-model="dispatchForm.subscribers.language">
												<label class="custom-control-label" for="subscriberLanguageAll">All</label>
											</div>
											<div class="custom-control custom-radio mr-3" v-for="language in subscribersLanguages">
							                    <input type="radio" name="subscribersLanguage" class="custom-control-input" :id="'subscriberLanguage'+language.id" :value="language.id" v-model="dispatchForm.subscribers.language">
												<label class="custom-control-label" :for="'subscriberLanguage'+language.id">{{ language.name }}</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div v-else>
								<div class="alert alert-warning">
									You have no subscribers at the moment.
								</div>
							</div>

							<div v-show="membersChoiceParent || subscribersChoiceParent">
								<button type="submit" class="btn btn-primary btn-user btn-block shadow" :disabled="form.busy">Dispatch Letter</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				newsletters: [],
				selectedNewsletter: {
					id: '',
					subject: '',
					content: ''
				},

				editSpace: false,
				form: new Form({
					id: '',
					subject: '',
					content: '',
				}),

				membersChoiceParent: false,
				membersChoice: false,
				membersLanguages: [],
				membersCities: [],
				regions: [],

				subscribersChoiceParent: false,
				subscribersChoice: false,
				subscribersLanguages: [],

				dispatchForm: new Form({
					members: {
						select: false,
						language: 0,
						cities: []
					},
					subscribers: {
						select: false,
						language: 0
					},
				}),
			}
		},
		watch: {
			'dispatchForm.members.select': function(value) {
				if (value) {
					this.fetchMembersLanguages()
					this.fetchMembersCities()
					this.membersChoice = true
				} else {
					this.dispatchForm.members.language = ''
					this.dispatchForm.members.regions = []
					this.membersChoice = false
				}
			},
			'dispatchForm.subscribers.select': function(value) {
				if (value) {
					this.fetchSubscribersLanguages()
					this.subscribersChoice = true
				} else {
					this.dispatchForm.subscribers.language = ''
					this.subscribersChoice = false
				}
			},
		},
		methods: {
			fetchNewsletters() {
				const loader = this.$loading.show()
				
				axios.get('/api/newsletter')
				.then(response => {
					this.newsletters = response.data
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
	        		loader.hide()
	        	})
			},
			viewNewsletter(newsletter) {
				this.selectedNewsletter = newsletter
			},
			selectNewsletter(newsletter) {
				this.selectedNewsletter = newsletter

				this.getTotalMembers()
				this.getTotalSubscribers()
			},
			deleteNewsletter(id) {
				axios.delete('/api/newsletter/' + id)
				.then(() => {
					Toast.fire({
						type: 'success',
						title: 'Newsletter deleted successfully.'
					})

					this.fetchNewsletters()
				})
				.catch(err => {
					console.log(err)
				})
			},
			editNewsletter(newsletter) {
				this.form.fill(newsletter)

				this.editSpace = true
			},
			update() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.put('/api/newsletter/' + this.form.id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Newsletter saved!'
					})

					this.form.reset()
					this.fetchNewsletters()
					this.editSpace = false
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			updateAndTest() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.put('/api/newsletter/update_test_newsletter/' + this.form.id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Newsletter saved! And you can check your email for a sample.'
					})

					this.form.reset()
					this.fetchNewsletters()
					this.editSpace = false
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			test() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/api/newsletter/test_newsletter')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Please check your email'
					})
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			fetchMembersLanguages() {
                axios.get('/api/organization_members/languages')
                .then(response => {
                    this.membersLanguages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
            },
            fetchMembersCities() {
                axios.get('/api/organization_members/cities')
                .then(response => {
                    this.membersCities = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of cities ' + err)
                })
            },
            fetchSubscribersLanguages() {
                axios.get('/api/organization_subscription/languages')
                .then(response => {
                    this.subscribersLanguages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
            },
            getTotalMembers() {
	        	axios.get('/api/counter/organization/members')
	        	.then(response => {
	        		if (response.data > 0)
	        			this.membersChoiceParent = true
	        	})
	        },
	        getTotalSubscribers() {
	        	axios.get('/api/counter/organization/subscribers')
	        	.then(response => {
	        		if (response.data > 0)
	        			this.subscribersChoiceParent = true
	        	})
	        },
	        dispatch() {
	        	this.dispatchForm.post('/api/newsletter/dispatch_newsletter/' + this.selectedNewsletter.id)
	        	.then(response => {
	        		Swal.fire({
	        			type: 'success',
	        			title: 'Newsletter Dispatched Successfully',
	        		})
	        		.then(() => {
	        			this.fetchNewsletters()
	        		})
	        	})
	        	.catch(err => {
	        		var message = ''

	        		if(err.response.status === 400) {
	        			message = 'Please select a target'
		        	}
	        		
	        		Swal.fire({
	        			type: 'error',
	        			title: 'Oops!',
	        			text: message ? message : 'Something went wrong'
	        		})
	        	})
	        	.finally(() => {
	        		$('#dispatchNewsletter').modal('hide')
	        	})
	        }
		},
		created() {
			document.title = 'Manage Newsletters | ILA'

			this.fetchNewsletters()
		}
	}
</script>