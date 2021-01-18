<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Blog<br>
				<div class="h6 mt-1 text-gray-500">Manage your blog</div>
			</h1>
		</div>

		<alert-success :form="form">Request was successful!</alert-success>
		
		<div class="card shadow mb-4"  v-if="posts.length > 0">
			<div class="table-responsive" v-show="!editSpace">
				<table class="table table-borderless table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Number of Comments</th>
							<th>Owner</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(post, index) in posts">
							<td>{{ index+1 }}</td>
							<td>
								<a :href="'/organization/' + post.organization_id + '/post/' + post.id" target="_blank">{{ post.title }}</a>
								<p v-if="post.verified == 0" class="small">Unverified</p>
							</td>
							<td>{{ post.comments_count }}</td>
							<td>{{ post.user.name }}</td>
							<td>
								<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#viewPost" @click="selectPost(post)">Quick View</button>
								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="deletePost(post.id)">Delete</button>
								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" @click="editPost(post)">Edit</button>

								<span v-if="$parent.user.role.name === 'admin' || $parent.user.role.name === 'super'">
									<button v-if="post.verified === 0" type="button" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" @click="verifyPost(post.id)">Verify</button>
									<button v-else type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" @click="verifyPost(post.id)">Unverify</button>

								
									<button v-if="post.status == 0" type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" @click="modifyStatusPost(post.id)">Publish</button>
									<button v-else type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" @click="modifyStatusPost(post.id)">Keep as draft</button>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div v-show="editSpace" ref="formContainer">
				<form class="user" @submit.prevent="update" @keydown="form.onKeydown($event)">
					<div class="card-header py-3">
						<div class="form-group">
							<label class="text-primary" for="title"></label>
							<input type="text" name="title" class="form-control form-control-user" id="title" :class="{ 'is-invalid': form.errors.has('title') }" placeholder="Title" v-model.trim="form.title" required>
							<has-error :form="form" field="title"></has-error>
						</div>
					</div>
					<div class="card-body">
							<div class="form-group">
								<tinymce id="d1" v-model="form.content"></tinymce>
							</div>

							<div class="form-group">
								<label class="text-primary" for="excerpt">Excerpt</label>
								<input type="text" name="excerpt" class="form-control form-control-user" id="excerpt" :class="{ 'is-invalid': form.errors.has('excerpt') }" placeholder="Short description of the post" v-model.trim="form.excerpt" required>
								<has-error :form="form" field="excerpt"></has-error>
							</div>

							<div class="form-group">
								<label class="text-primary" for="featured_image">Featured Image <span class="text-danger small">(Ignore if you do not want to change the image)</span></label>
								<input type="file" name="featured_image" class="form-control form-control-user" id="featured_image" :class="{ 'is-invalid': form.errors.has('featured_image') }" @change="getImage">
								<has-error :form="form" field="featured_image"></has-error>
							</div>

							<div class="form-group row">
								<div class="col-lg-6 mb-3">
									<button type="button" class="btn btn-secondary btn-user btn-block" @click="editSpace = false">Cancel</button>
								</div>
								<div class="col-lg-6 mb-3">
									<button type="submit" class="btn btn-primary btn-user btn-block">Update</button>
								</div>
							</div>
					</div>
				</form>
			</div>

			<!-- View Post -->
			<div class="modal fade" id="viewPost" tabindex="-1" role="dialog" aria-labelledby="postModal" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-primary" id="postModal">
								Title: <b>{{ selectedPost.title }}</b><br>
							</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fas fa-times"></i></span>
							</button>
						</div>
						<div class="modal-body">
							<div v-html="selectedPost.content"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-left-primary shadow h-100 py-2" v-else>
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Posts</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">There are no posts at the moment</div>
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
				posts: [],
				selectedPost: {},

				form: new Form({
					id: '',
					title: '',
					content: '',
					excerpt: '',
					featured_image: '',
					status: ''
				}),

				editSpace: false,
			}
		},
		methods: {
			fetchPosts() {
				const loader = this.$loading.show()
				
				axios.get('/api/blog/post')
				.then(response => {
					this.posts = response.data
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
	        		loader.hide()
	        	})
			},
			editPost(post) {
				this.form.fill(post)

				this.editSpace = true
			},
			selectPost(post) {
				this.selectedPost = post
			},
			getImage(e) {
                let file = e.target.files[0];
                var reader = new FileReader();

                if (file['size'] < 1048576 && (file['type'] == 'image/jpeg' || file['type'] == 'image/png' || file['type'] == 'image/jpg')) {
                    reader.onloadend = (file) => {
                        this.form.featured_image = reader.result;
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
			update() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.put('/api/blog/post/' + this.form.id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Post updated!'
					})

					this.form.reset()
					this.fetchPosts()
					this.editSpace = false
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			},
			deletePost(id) {
				axios.delete('/api/blog/post/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Post was deleted successfully!'
					})

					this.fetchPosts()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Something went wrong'
					})

					console.log(err)
				})
			},
			verifyPost(id) {
				axios.put('/api/blog/post/verify/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Post verification was modified successfully!'
					})

					this.fetchPosts()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Something went wrong'
					})

					console.log(err)
				})
			},
			modifyStatusPost(id) {
				axios.put('/api/blog/post/status/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Post visibility was modified successfully!'
					})

					this.fetchPosts()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Something went wrong'
					})

					console.log(err)
				})
			},
		},
		created() {
			document.title = 'Manage Blog | ILA'

			this.fetchPosts()
		},
		mounted() {

		}
	}
</script>

<style type="text/css">
	.mce-tinymce .mce-edit-area iframe {
		min-height: 300px;
	}
</style>