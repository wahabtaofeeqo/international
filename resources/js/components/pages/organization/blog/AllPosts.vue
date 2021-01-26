<template>
	<div class="container">
		<div v-if="posts.length > 0">
			<div class="row">
				<div class="col-lg-4" v-for="post in posts">
					<div class="course bg-white h-100 align-self-stretch">
						<figure class="m-0">
							<a :href="'/organization/'+organization+'/post/'+post.id">
								<img class="img-fluid" alt="Image" :src="'/images/posts/'+post.featured_image">
							</a>
						</figure>
						<div class="course-inner-text py-4 px-4">
							<div class="meta"><span class="icon-clock-o"></span>{{ post.created_at | moment('calendar') }}</div>
							<h3>
								<a :href="'/organization/'+organization+'/post/'+post.id">{{ post.title }}</a>
							</h3>
							<p v-html="post.excerpt.substr(0, 100)"></p>
						</div>
						<div class="d-flex border-top stats">
							<div class="py-3 px-4"><span class="icon-user"></span> {{ post.user.name }}</div>
							<div class="py-3 px-4 w-25 ml-auto border-left"><span class="icon-chat"></span> {{ post.comments_count }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="bg-white alert" v-else>
			<h4 class="text-center">There is nothing to show you at the moment.</h4>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				organization: '',
				posts: []
			}
		},
		methods: {
			fetchPosts() {
				axios.get('/api/organization/blog/posts/' + this.organization)
				.then(response => {
					if (response.data != '') {
						this.posts = response.data.data
					}
				})
				.catch(err => {
					console.log(err)
				})
			},
		},
		created() {
			Fire.$on('readyForBlog', (id) => {
				this.organization = id

				this.fetchPosts()
			})

			Fire.$on('refreshPost', () => {
				this.fetchPosts()
			})
		},
	}
</script>
