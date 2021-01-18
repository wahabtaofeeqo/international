<template>
	<div class="site-wrap" v-show="visible">
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icon-close2 js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>

		<header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
			<div class="container-fluid">
				<div class="d-flex align-items-center">
					<div class="site-logo mr-auto w-25">
						<router-link :to="{ name: 'OrganizationHome' }">
							{{ organization.name }}
						</router-link>
					</div>
					<div class="mx-auto text-center">
						<nav class="site-navigation position-relative text-right" role="navigation">
							<ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
								<li><a href="#home-section" class="nav-link">Home</a></li>
								<li><a href="#articles-section" class="nav-link">Articles</a></li>
								<li><a href="#members-section" class="nav-link">Members</a></li>
							</ul>
						</nav>
					</div>

					<div class="ml-auto w-25">
						<nav class="site-navigation position-relative text-right" role="navigation">
							<ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
								<li class="cta"><a href="#contact-section" class="nav-link"><span>Contact Us</span></a></li>
							</ul>
						</nav>
						<a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right">
							<span class="icon-menu h3"></span>
						</a>
					</div>
				</div>
			</div>
		</header>

		<div class="intro-section" id="home-section">
			<div class="slide-1" style="background-image: url('images/hero_1.jpg');" data-stellar-background-ratio="0.5">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12">
							<div class="row align-items-center">
								<div class="col-lg-6 mb-4">
									<h1  data-aos="fade-up" data-aos-delay="100">
										Learn About {{ organization.name }}
										<sup>
											<img :src="'/public/images/logos/'+organization.logo" alt="logo" width="40" height="40" class="img-fluid">
										</sup>
									</h1>
									<p class="mb-4"  data-aos="fade-up" data-aos-delay="200">{{ organization.description }}</p>
									<p data-aos="fade-up" data-aos-delay="300">
										<router-link :to="'/organization/' + organization.id + '/register'" class="btn btn-primary py-3 px-5 btn-pill" v-show="!user">Join Us Now</router-link>
										<a href="/home" class="btn btn-primary py-3 px-5 btn-pill" v-show="user">Open Dashboard</a>
									</p>
								</div>
								<div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="500" v-show="!user">
									<login></login>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="site-section courses-title" id="articles-section">
			<div class="container">
				<div class="row mb-5 justify-content-center">
					<div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
						<h2 class="section-title">Articles</h2>
					</div>
				</div>
			</div>
		</div>

		<div class="site-section courses-entry-wrap" data-aos="fade-up" data-aos-delay="100">
			<div class="container">
				<div class="row">
					<all-posts></all-posts>
				</div>
			</div>
		</div>

		<div class="site-section" id="members-section">
			<div class="container">
				<div class="row mb-5 justify-content-center">
					<div class="col-lg-7 mb-5 text-center"  data-aos="fade-up" data-aos-delay="">
						<h2 class="section-title">Our Members</h2>
						<p class="mb-5">Our dedicated team are ready to give you the best content on what our organization is here to offer!</p>
					</div>
				</div>
				<div class="row" v-if="visibleMembers.length > 0">
					<div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100" v-for="member in visibleMembers">
						<div class="teacher text-center">
							<img :src="'/public/images/avatars/'+member.user.photo" alt="Photo" class="img-fluid w-50 rounded-circle mx-auto mb-4" style="width: 150px; height: 150px;">
							<div class="py-2">
								<h3 class="text-black">{{ member.user.name }}</h3>
								<p class="position">{{ member.user.role.name.toUpperCase() }}</p>
								<p>
									<a class="btn btn-primary btn-pill btn-sm mr-2" :href="'mailto:'+member.user.email"><i class="icon-contact_mail"></i></a>
									<a class="btn btn-secondary btn-pill btn-sm mr-2" :href="'tel:'+member.user.phone_number"><i class="icon-phone"></i></a>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="alert alert-info" data-aos="fade-up" data-aos-delay="100" v-else>
					There are no members in the team yet! Do stay in touch.
				</div>
			</div>
		</div>

		<div class="site-section bg-light" id="contact-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-7">
						<h2 class="section-title mb-3">Message Us</h2>
						<p class="mb-5">We are readily here to assist you through whatever means possible. Do relay your message and our support team will contact you shortly.</p>

						<alert-success :form="contactForm">Thank you for your message.</alert-success>

						<form @submit.prevent="submitContactMessage" @keydown="contactForm.onKeydown($event)" data-aos="fade">
							<div class="form-group row">
								<div class="col-md-12">
									<input type="text" class="form-control" placeholder="Name" :class="{ 'is-invalid': contactForm.errors.has('name') }" v-model.trim="contactForm.name" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<input type="email" class="form-control" placeholder="Email" :class="{ 'is-invalid': contactForm.errors.has('email') }" v-model.trim="contactForm.email" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<input type="text" class="form-control" placeholder="Subject" :class="{ 'is-invalid': contactForm.errors.has('subject') }" v-model.trim="contactForm.subject" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
									<textarea class="form-control" id="" cols="30" rows="10" placeholder="Write your message here." :class="{ 'is-invalid': contactForm.errors.has('message') }" v-model="contactForm.message" required></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="Send Message" :disabled="contactForm.busy">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
    	</div>

    	<Footer></Footer>
	</div>
</template>

<script>
	import Login from '../../auth/organization/Login.vue'
	import Blog from './blog/AllPosts.vue'
	import Footer from './sections/Footer.vue'

	export default {
		components: {
			'login': Login,
			'all-posts': Blog,
			'Footer': Footer
		},
		data() {
			return {
				visible: false,
				organization: {
					id: '',
					name: '',
					description: '',
					city: {
						name: '',
						region: {
							name: '',
							country: {
								name: '',
							}
						}
					},
				},
				user: false,

				languages: [],

				subscriptionForm: new Form({
					email: '',
					language_id: '',
					organization_id: ''
				}),

				contactForm: new Form({
					name: '',
					email: '',
					subject: '',
					message: '',
					organization_id: '',
				}),

				visibleMembers: []
			}
		},
		methods: {
			getOrganization() {
				axios.get('/api/organization/'+this.$parent.organization_id)
				.then(response => {
					this.organization = response.data

					if (response.data.affiliate == 1) {
						this.visible = true
						this.fetchVisibleMembers(this.organization.id)

						Fire.$emit('readyForBlog', this.organization.id)
					} else {
						Swal.fire({
							type: 'info',
							title: 'Public Access!',
							text: 'Organization has decided not to share its information with the public yet!'
						})
					}
				})
				.catch(err => {
					Swal.fire({
						type: 'error',
						title: 'Oops!',
						html: 'Something is wrong with this page.<br>Please check back later'
					})
					.then(() => {
						document.location.href = '/'
					})
				})
			},
			checkAuthenticatedUser() {
				axios.get('/api/user')
				.then(() => {
					this.user = true
				})
				.catch(err => {
					console.log(err.response.data.message)
				})
			},
			fetchLanguages() {
                axios.get('/api/language')
                .then(response => {
                    this.languages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
            },
			subscribe() {
				this.subscriptionForm.organization_id = this.organization.id

				const loader = this.$loading.show({
					container: this.$refs.subscription
				})

				this.subscriptionForm.post('/api/organization_subscription')
				.then(response => {
					this.subscriptionForm.reset()

					Toast.fire({
						type: 'success',
						title: 'Thanks!'
					})
				})
				.catch(err => {
					console.log('Cannot subscribe at the moment.')
				})
				.finally(() => {
					loader.hide()
				})
			},
			submitContactMessage() {
				this.contactForm.organization_id = this.organization.id

				const loader = this.$loading.show({
					container: this.$refs.contact
				})

				this.contactForm.post('/api/organization_contact_message')
				.then(response => {
					this.contactForm.reset()

					Toast.fire({
						type: 'success',
						title: 'Thanks!'
					})
				})
				.catch(err => {
					console.log('Cannot submit message at the moment.')
				})
				.finally(() => {
					loader.hide()
				})
			},
			fetchVisibleMembers(id) {
				axios.get('/api/organization_members/visible/'+id)
				.then(response => {
					this.visibleMembers = response.data
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Oops! We cannot fetch the users right now.'
					})

					console.log(err)
				})
			}
		},
		created() {
			this.checkAuthenticatedUser()
			this.fetchLanguages()

			Fire.$on('loggedIn', () => {
				this.user = true
			})
		},
		mounted() {
			this.getOrganization()
		},
	}
</script>

<style type="text/css">
	.icon-menu {
		color: #2ba2da;
	}
</style>
