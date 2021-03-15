<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		</div>

		<!-- Notifications -->
		<div class="card shadow mb-4">
			<div class="card-body" ref="progress">
				<h4 class="small font-weight-bold">Social Media Integration <span class="float-right">{{ socialProfilePercentage }}%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar bg-primary" role="progressbar" :style="'width:' + socialProfilePercentage + '%'" :aria-valuenow="socialProfilePercentage+'%'" aria-valuemin="0" aria-valuemax="100"></div>
				</div>

				<h4 class="small font-weight-bold">Organization Membership <span class="float-right">{{ membershipProfilePercentage }}%</span></h4>
				<div class="progress mb-4">
					<div class="progress-bar bg-success" role="progressbar" :style="'width:' + membershipProfilePercentage + '%'" :aria-valuenow="membershipProfilePercentage+'%'" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8 mb-4">
				<!-- If user is not registered in an organization yet -->
				<div class="row">
					<div class="col-sm-12">
						<div class="card border-left-primary shadow h-100 py-2" v-if="user.organization_id == null">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Organization</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">You have not registered or joined any yet!</div>
									</div>
									<div class="col-auto">
										<button v-if="!organizationEntry" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" @click="showOrganizationEntry"><i class="fas fa-joint mr-2"></i> Register one now</button>
										<button class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm" @click="organizationEntry = false" v-else><i class="fa fa-times mr-2"></i> Close</button>
									</div>
								</div>

								<div class="mt-5 mt-5 mt-5" v-show="organizationExistence && !organizationEntry">
									<div class="mb-3">
										<div class="h5 mb-1 font-weight-bold text-warning">Oh! We think there is already an organization registered with your name and slogan.</div>
										<div class="h6 mb-0 font-weight-bold text-gray-700">How would you like to proceed?</div>
									</div>
									
									<a :href="'/organization/'+existence.id" target="__blank" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">View the Organization</a>
									<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" @click="joinOrganization">Join the Organization</button>
									<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="registerAnyway">Register Anyway</button>
								</div>

								<div class="mt-5 mt-5 mt-5" v-show="organizationEntry" ref="organizationEntry">
									<div class="alert alert-info" v-show="!organizationForm">
										You have submitted a query for an organization already!
										You will be notified by mail once it is approved or denied.
									</div>

									<form class="user" v-show="organizationForm" @submit.prevent="registerOrganization" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
										<div class="form-group">
											<input type="text" name="name" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name of the organization" v-model="form.name" required>
											<has-error :form="form" field="name"></has-error>
										</div>
										<div class="form-group">
											<input type="text" name="slogan" id="slogan" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('slogan') }" placeholder="Your slogan" v-model="form.slogan" required>
											<has-error :form="form" field="slogan"></has-error>
										</div>
										<div class="form-group">
											<input type="text" name="description" id="description" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('description') }" placeholder="Write a brief introduction about your organization" v-model="form.description" required>
											<has-error :form="form" field="description"></has-error>
										</div>
										<div class="form-group">
											<input type="text" name="address" id="address" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('address') }" placeholder="Headquarters of the organization" v-model="form.address" required>
											<has-error :form="form" field="address"></has-error>
										</div>
										<div class="form-group">
											<div class="row" v-show="locationChooser">
												<div class="col-sm-4 mb-3 mb-sm-0">
													<select class="form-control form-control-user custom-select" v-model="selectedCountry" name="country" @change="fetchRegions" :required="locationChooser">
														<option value="" disabled>Country</option>
														<option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
													</select>
												</div>
												<div class="col-sm-4 mb-3 mb-sm-0">
													<select class="form-control form-control-user custom-select" v-model="selectedRegion" name="region" @change="fetchCities" :required="locationChooser">
														<option value="" disabled>Region</option>
														<option :value="region" v-for="region in regions" :key="region.id">{{ region.name }}</option>
													</select>
												</div>
												<div class="col-sm-4">
													<select class="form-control form-control-user custom-select" name="city" :class="{ 'is-invalid': form.errors.has('city') }" v-model="form.city" :required="locationChooser">
														<option value="" disabled>City</option>
														<option :value="city" v-for="city in cities" :key="city.id">{{ city.name }}</option>
													</select>
												</div>

												<has-error :form="form" field="city"></has-error>
											</div>
											<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" id="useUserLocation" v-model="useUserLocation" @change="useUserLocationToggle">
												<label class="custom-control-label" for="useUserLocation">Use my current country, region and city as the organization's location</label>
											</div>
										</div>
										<div class="form-group">
							                <div class="input-group">
							                    <div class="input-group-prepend" title="Logo">
							                        <div class="input-group-text"><i class="fas fa-image"></i></div>
							                    </div>
							                    <input type="file" id="logo" name="logo" class="form-control form-control-user" @change="getPhoto" :class="{ 'is-invalid': form.errors.has('logo') }" required>
							                </div>
							                <span class="small text-primary">Upload a logo</span>
							                <has-error :form="form" field="logo"></has-error>
							            </div>
							            <div class="form-group">
							            	<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" id="affiliate" v-model="form.affiliate">
												<label class="custom-control-label" for="affiliate">Make my organization publicly available for ILA</label>
											</div>
							            </div>

							            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-user btn-block">
							                Register Organization
							            </button>
									</form>
								</div>
							</div>
						</div>

						<div class="card border-left-success shadow h-100 py-2" v-else>
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Organization</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">You have been accepted!</div>
									</div>
									<div class="col-auto" v-if="user.organization != null">
										<a :href="'/organization/' + user.organization.id" target="__blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-globe fa-sm text-white-50 mr-2"></i> Visit Organization Page</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Account settings -->
			<div class="col-lg-4 mb-4">
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Profile Details</h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-borderless">
								<tr>
									<th>Name</th>
									<td>{{ user.name }}</td>
								</tr>
								<tr>
									<th>Email</th>
									<td>{{ user.email }}</td>
								</tr>
								<tr>
									<th>Phone</th>
									<td>+{{ user.city.country.phone_index }}{{ user.phone_number }}</td>
								</tr>
								<tr>
									<th>Country</th>
									<td>{{ user.city.country.name }}</td>
								</tr>
								<tr>
									<th>Region</th>
									<td v-if="user.city.region != null">{{ user.city.region.name }}</td>
								</tr>
								<tr>
									<th>City</th>
									<td>{{ user.city.name }}</td>
								</tr>
							</table>
						</div>
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
				organizationEntry: false,
				organizationForm: true,
				organizationExistence: false,

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
                        },

                        country: {
                            id: '',
                            name: '',
                            phone_index: ''
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

				form: new Form({
					name: '',
					slogan: '',
					description: '',
					logo: '',
					address: '',
					city: '',
					affiliate: true
				}),

				useUserLocation: false,
				locationChooser: true,

				socialProfilePercentage: 0,
				membershipProfilePercentage: 0,

				countries: [],
				selectedCountry: '',

                regions: [],
                selectedRegion: '',

                cities: [],

                existence: {
                	id: ''
                }
			}
		},
		methods: {
			getAuthenticatedUser() {
	            axios.get('/api/user')
	            .then(response => {
	                this.user = response.data
	                this.checkSocialMediaIntegration()
	                this.checkOrganizationMembership()
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
	        checkSocialMediaIntegration() {
	        	var socialmedia = this.user.social_profile

				if (socialmedia != null) {
					if (socialmedia.skype != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.facebook != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.twitter != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.discord != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.slack != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.whatsapp != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}
					if (socialmedia.linkedin != null) {
						this.socialProfilePercentage += (1 / 7 * 100)
					}

					this.socialProfilePercentage = Math.ceil(this.socialProfilePercentage)
				}
	        },
	        checkOrganizationMembership() {
	        	var membership = this.user.membership

	        	if (membership != null) {
	        		this.membershipProfilePercentage = 50

	        		if (membership.verified == 1) {
	        			this.membershipProfilePercentage = 100
	        		}
	        	}
	        },
	        showOrganizationEntry() {
	        	this.organizationEntry = true

	        	const loader = this.$loading.show({
	        		container: this.$refs.organizationEntry
	        	})

	        	setTimeout(() => {
	        		// User already submitted a request for membership
	        		if (this.user.membership != null) {
		        		this.organizationForm = false
		        	}

		        	this.fetchCountries()

		        	loader.hide()
	        	}, 500)
	        },
	        fetchCountries() {
                axios.get('/api/all-countries')
                .then(response => {
                    this.countries = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },
            fetchRegions() {
                axios.get('/api/region/country/'+this.selectedCountry.id)
                .then(response => {
                    this.regions = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of regions ' + err)
                })
            },
            fetchCities() {
                axios.get('/api/city/region/'+this.selectedRegion.id)
                .then(response => {
                    this.cities = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of cities ' + err)
                })
            },
            useUserLocationToggle() {
            	if (this.useUserLocation) {
            		this.locationChooser = false

            		this.form.city = this.user.city
            	} else {
            		this.form.city = ''
            		this.locationChooser = true
            	}
            },
            getPhoto(e) {
                let file = e.target.files[0];
                var reader = new FileReader();

                if (file['size'] < 1048576 && (file['type'] == 'image/jpeg' || file['type'] == 'image/png' || file['type'] == 'image/jpg')) {
                    reader.onloadend = (file) => {
                        this.form.logo = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    Swal.fire(
                        'Oops...',
                        'Please check the format (JPEG, JPG, PNG) and size (< 1MB) of the image.',
                        'error'
                    )
                }
            },
            registerOrganization() {
            	const loader = this.$loading.show({
            		container: this.$refs.organizationEntry
            	})

            	this.form.post('/organization/register')
            	.then(response => {
        			Swal.fire({
        				type: 'success',
        				title: 'Registration Successful!',
        				text: 'You will redirected now to kick-start as your organization\'s administrator.'
        			})
        			.then(() => {
        				document.location.href = '/home'
        			})
            	})
            	.catch(err => {
            		if(err.response.status === 409) {
            			this.existence = JSON.parse(err.response.data.message)

            			this.organizationEntry = false
            			this.organizationExistence = true
            		} else {
            			Toast.fire({
	            			type: 'error',
	            			title: 'Something went wrong!',
	            			text: 'Please try again later'
	            		})
            		}
            	})
            	.finally(() => {
            		loader.hide()
            	})
            },
            joinOrganization() {
            	const loader = this.$loading.show()

            	this.form.post('/organization/join/')
            	.then(response => {
        			Swal.fire({
        				type: 'success',
        				title: 'Application Submitted!',
        				text: 'Your organization should approve your request within two days.'
        			})
        			.then(() => {
        				document.location.reload()
        			})
            	})
            	.catch(err => {
        			Toast.fire({
            			type: 'error',
            			title: 'Something went wrong!',
            		})
            	})
            	.finally(() => {
            		loader.hide()
            	})
            },
            registerAnyway() {
            	const loader = this.$loading.show()

            	this.form.post('/organization/register-anyway/')
            	.then(response => {
        			Swal.fire({
        				type: 'success',
        				title: 'Registration Successful!',
        				text: 'You will redirected now to kick-start as your organization\'s administrator.'
        			})
        			.then(() => {
        				window.location = '/home'
        			})
            	})
            	.catch(err => {
        			Toast.fire({
            			type: 'error',
            			title: 'Something went wrong!',
            		})
            	})
            	.finally(() => {
            		loader.hide()
            	})
            }
		},
		created() {
			document.title = 'Dashboard | ILA'

			this.getAuthenticatedUser()
		},
	}
</script>
