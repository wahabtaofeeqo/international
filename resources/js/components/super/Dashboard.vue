<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		</div>

		<!-- Information -->
		<div class="row">
			<!-- Members -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Members (Total)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalMembers }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-users fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Articles -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Articles (Total)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalArticles }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-pen fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Subscribers -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Subscribers (Total)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalSubscribers }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-list fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Messages -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-danger shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unread Messages (Total)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalMessages }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comment fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Pending membership requests -->
		<div class="card border-left-warning shadow h-100 py-2 mb-4" v-show="pendingRequests">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Membership</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">You have pending requests from other users to join your organization.</div>
					</div>
					<div class="col-auto">
						<router-link class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" :to="{ name: 'SuperMembersRequests' }"><i class="fas fa-eye mr-2"></i> Check them</router-link>
					</div>
				</div>
			</div>
		</div>

		<!-- Main -->
		<div class="row">
			<!-- Member selection for site visibility -->
			<div class="col-xl-8 col-lg-7">
				<div class="row">
					<div class="col-sm-12">
						<div class="card shadow h-100 border-left-success py-2 mb-4" ref="membersContainer">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-uppercase mb-1 text-success">Member Display</div>
										<div class="h5 mb-1 font-weight-bold text-gray-800">Choose members in your organization to display on ILA.</div>
										<div class="h6 mb-0 text-gray-600">You can only add 3 people however.</div>
									</div>
									<div class="col-auto">
										<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#promoteModal" @click="fetchMembers"><i class="fas fa-level-up-alt mr-2"></i> Choose them now</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Pie Chart -->
			<div class="col-xl-4 col-lg-5">
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Blog Overview Chart</h6>
					</div>
					<div class="card-body">
						<blog-pie v-if="blog.published > 0 | blog.draft > 0" :published="blog.published" :draft="blog.draft"></blog-pie>
						<div class="alert alert-primary" v-else>
							You have not registered any blog posts yet.
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="promoteModal" tabindex="-1" role="dialog" aria-labelledby="promotionModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-primary" id="promotionModal">
							Upgrade members to the your ILA site
						</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fas fa-times"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-borderless" v-if="members.length > 0">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th></th>
								</tr>
								<tr v-for="(member, index) in members">
									<td>{{ index+1 }}</td>
									<td>{{ member.user.name }}</td>
									<td>
										<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" @click="promoteMember(member.id)" v-if="member.visible == 0">Promote</button>
										<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="demoteMember(member.id)" v-else>Demote</button>
									</td>
								</tr>
							</thead>
						</table>
						<div class="card border-left-warning shadow h-100 py-2 mb-4" v-else>
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Membership</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">No members yet.</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import BlogPie from '../../charts/BlogPie'

	export default {
		components: {
			BlogPie
		},
		data() {
			return {
				user: {
                    id: '',
                    name: '',
                    email: '',
                    phone_number: '',
                    city: {
                        id: '',
                        name: '',
                        region: {
                            id: '',
                            name: '',
                            country: {
                                id: '',
                                name: '',
                                phone_index: ''
                            }
                        }
                    },
                    language: {
                        id: '',
                        name: ''
                    },
                    photo: '',
                    birth_year: '',
                    gender: '',
                    organization_id: '',
                    membership: ''
                },

                organization: {
                	id: '',
                	name: '',
                	slogan: '',
                	address: '',
                	description: '',
                	affiliate: ''
                },

                totalMembers: 0,
                totalArticles: 0,
                totalSubscribers: 0,
                totalMessages: 0,

                pendingRequests: false,

                blog: {
                	published: 0,
                	draft: 0
                },

                members: []
			}
		},
		methods: {
			getAuthenticatedUser() {
	            axios.get('/api/user')
	            .then(response => {
	                this.user = response.data
	            })
	            .catch(err => {
	                Swal.fire({
	                    type: 'error',
	                    title: 'Something went wrong',
	                    text: 'Please check back later'
	                })
	                .then(() => {
	                    document.location.href = '/'
	                })
	            })
	        },
	        getOrganizationData() {
	        	axios.get('/api/organization/')
	        	.then(response => {
	        		this.organization = response.data
	        	})
	        	.catch(err => {
	        		console.log('We could not get the organization data ' + err)
	        	})
	        },
	        getTotalMembers() {
	        	axios.get('/api/counter/organization/members')
	        	.then(response => {
	        		this.totalMembers = response.data
	        	})
	        },
	        getTotalArticles() {
	        	axios.get('/api/counter/organization/articles')
	        	.then(response => {
	        		this.totalArticles = response.data
	        	})
	        },
	        getTotalSubscribers() {
	        	axios.get('/api/counter/organization/subscribers')
	        	.then(response => {
	        		this.totalSubscribers = response.data
	        	})
	        },
	        getTotalMessages() {
	        	axios.get('/api/counter/organization/messages')
	        	.then(response => {
	        		this.totalMessages = response.data
	        	})
	        },
	        getPendingRequests() {
	        	axios.get('/api/counter/organization/requests')
	        	.then(response => {
	        		if (response.data > 0) {
	        			this.pendingRequests = true
	        		}
	        	})
	        },
	        getTotalPublishedPosts() {
	        	axios.get('/api/counter/organization/posts/published')
	        	.then(response => {
	        		this.blog.published = response.data
	        	})
	        },
	        getTotalDraftPosts() {
	        	axios.get('/api/counter/organization/posts/draft')
	        	.then(response => {
	        		this.blog.draft = response.data
	        	})
	        },
	        fetchMembers() {
				const loader = this.$loading.show({
					container: this.$refs.membersContainer
				})

				axios.get('/api/organization_members')
				.then(response => {
					this.members = response.data
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Oops! We cannot fetch the users right now.'
					})

					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			promoteMember(id) {
				axios.put('/api/organization_members/promoteMember/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Member upgraded'
					})

					this.fetchMembers()
				})
				.catch(err => {
					var message = 'Something went wrong'

					if (err.response.status === 400) {
						message = err.response.data.message
					}

					Swal.fire({
						type: 'error',
						title: 'Oops',
						text: message
					})
				})
				.finally(() => {
					$('#promoteModal').modal('hide')
				})
			},
			demoteMember(id) {
				axios.put('/api/organization_members/demoteMember/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Member downgraded'
					})

					this.fetchMembers()
				})
				.catch(err => {
					var message = 'Something went wrong'

					Swal.fire({
						type: 'error',
						title: 'Oops',
						text: message
					})
				})
				.finally(() => {
					$('#promoteModal').modal('hide')
				})
			},
		},
		created() {
			document.title = 'Super Dashboard | ILA'

			this.getAuthenticatedUser()
			this.getOrganizationData()

			this.getTotalPublishedPosts()
			this.getTotalDraftPosts()
			this.getTotalMembers()
			this.getTotalArticles()
			this.getTotalSubscribers()
			this.getTotalMessages()

			this.getPendingRequests()
		},
		mounted () {
			
		},
	}
</script>
