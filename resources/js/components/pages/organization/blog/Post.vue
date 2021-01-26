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
						<a :href="'/organization/'+organization.id">
							{{ organization.name }}
						</a>
					</div>
				</div>
			</div>
		</header>

		<div class="intro-section single-cover">
			<div class="slide-1" :style="'background-image: url(/images/posts/'+post.featured_image+');'" data-stellar-background-ratio="0.5">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12">
							<div class="row justify-content-center align-items-center text-center">
								<div class="col-lg-6">
									<h1 data-aos="fade-up" data-aos-delay="0">{{ post.title }}</h1>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="site-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 mb-5">
						<div class="mb-5">
							<p class="mb-4 small">
								{{ post.created_at | moment('calendar') }}
							</p>
							<div v-html="post.content"></div>
						</div>

						<!-- Comment Section -->
						<div class="pt-5">
							<h3 class="mb-5">{{ post.comments_count }} Comment(s)</h3>
							<ul class="comment-list" v-show="comments.length > 0">
								<li class="comment" v-for="(comment, index) in comments">
									<div class="vcard bio">
										{{ index+1 }}
									</div>
									<div class="comment-body">
										<h4>{{ comment.name }}</h4>
										<div class="meta small">{{ comment.created_at | moment('calendar') }}</div>
										<p v-html="comment.message"></p>
									</div>
								</li>
							</ul>

							<div class="comment-form-wrap pt-5">
								<h3 class="mb-5">Leave a comment</h3>

								<form class="p-5 bg-light" @submit.prevent="submitComment" @keydown="form.onKeydown($event)">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control" id="name" v-model.trim="form.name" required>
										<has-error :form="form" field="name"></has-error>
									</div>
									<div class="form-group">
										<label for="email">Email</label>
										<input type="email" class="form-control" id="email" v-model.trim="form.email" required>
										<has-error :form="form" field="email"></has-error>
										<span class="small text-info"><i class="fa fa-info"></i> We do not publish your email.</span>
									</div>

									<div class="form-group">
										<label for="message">Message</label>
										<textarea name="" id="message" cols="30" rows="10" class="form-control" v-model="form.message" required></textarea>
										<has-error :form="form" field="message"></has-error>
									</div>

									<div class="form-group">
										<input type="submit" value="Post Comment" class="btn btn-primary">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-4 pl-lg-5">
						<div class="mb-5 text-center border rounded course-instructor">
							<h3 class="mb-5 text-black text-uppercase h6 border-bottom pb-3">Writer</h3>
							<div class="mb-4 text-center">
								<img :src="'/images/avatars/'+post.user.photo" alt="Photo" class="w-50 rounded-circle mb-4" style="width: 150px; height: 150px;">
								<h3 class="h5 text-black mb-4">{{ post.user.name }}</h3>
								<p>
									<a class="btn btn-primary btn-pill btn-sm mr-2" :href="'mailto:'+post.user.email"><i class="icon-contact_mail"></i></a>
									<a class="btn btn-secondary btn-pill btn-sm mr-2" :href="'tel:'+post.user.phone_number"><i class="icon-phone"></i></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Other posts -->
		<div class="site-section courses-title bg-dark" id="courses-section">
			<div class="container">
				<div class="row mb-5 justify-content-center">
					<div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
						<h2 class="section-title">More Posts</h2>
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

		<Footer></Footer>
	</div>
</template>

<script>
	import Blog from './AllPosts.vue'
	import Footer from '../sections/Footer.vue'

	export default {
		components: {
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
				post: {
					id: '',
					title: '',
					content: '',
					status: 0,
					verified: 0,
					created_at: '2019-10-09',
					user: {
						id: '',
						name: '',
						email: '',
						phone_number: ''
					}
				},

				form: new Form({
					name: '',
					email: '',
					message: '',
					post_id: ''
				}),

				comments: [],
			}
		},
		methods: {
			getOrganization() {
				axios.get('/api/organization/'+this.$route.params.id)
				.then(response => {
					this.organization = response.data

					if (response.data.affiliate == 1) {
						this.visible = true

						Fire.$emit('readyForBlog', this.organization.id)

						this.fetchPost()
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
			fetchPost() {
				axios.get('/api/blog/post/' + this.$route.params.post_id)
				.then(response => {
					if (response.data.status == 1) {
						this.post = response.data

						document.title = this.post.title + ' | ' + this.organization.name

						this.fetchComments(this.post.id)
					}
					else {
						Swal.fire({
							type: 'info',
							title: 'Public Access',
							text: 'This blog post is not available on ' + this.organization.name
						})
						.then(() => {
							document.location.href = '/organization/' + this.organization.id
						})
					}
				})
				.catch(err => {
					console.log(err)
				})
			},
			submitComment() {
				this.form.post_id = this.post.id

				this.form.post('/api/blog/comment')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Submit was successful.'
					})

					this.form.reset()

					Fire.$emit('refreshPost')
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Something is wrong'
					})

					console.log(err)
				})
			},
			fetchComments(id) {
				axios.get('/api/organization/blog/comments/' + id)
				.then(response => {
					this.comments = response.data
				})
				.catch(err => {
					console.log('Error fetching comments.')
				})
			}
		},
		created() {
			Fire.$on('refreshPost', () => {
				this.fetchPost()
			})
		},
		mounted() {
			this.getOrganization()
		}
	}
</script>
