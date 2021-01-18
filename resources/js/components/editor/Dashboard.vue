<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
			<a :href="'/organization/'+organization.id" target="__blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-globe fa-sm text-white-50 mr-2"></i> Visit Affiliate Page</a>
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
			<!-- Counter -->
			<div class="col-xl-8 col-lg-7">
				<div class="row">
					<div class="col-sm-12">
						<div class="card border-left-success shadow h-100 py-2">
							<div class="card-body">
								<div class="row no-gutters align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Articles in your Organization (Total)</div>
										<div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalArticles }}</div>
									</div>
									<div class="col-auto">
										<i class="fas fa-pen fa-2x text-gray-300"></i>
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

				socialProfilePercentage: 0,
				membershipProfilePercentage: 0,

				totalArticles: 0,

				blog: {
                	published: 0,
                	draft: 0
                },
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
	        getOrganizationData() {
	        	axios.get('/api/organization/')
	        	.then(response => {
	        		this.organization = response.data
	        	})
	        	.catch(err => {
	        		console.log('We could not get the organization data ' + err)
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
	        getTotalArticles() {
	        	axios.get('/api/counter/organization/articles')
	        	.then(response => {
	        		this.totalArticles = response.data
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
		},
		created() {
			document.title = 'Dashboard | ILA'

			this.getAuthenticatedUser()
			this.getOrganizationData()

			this.getTotalPublishedPosts()
			this.getTotalDraftPosts()
			this.getTotalArticles()
		},
	}
</script>
