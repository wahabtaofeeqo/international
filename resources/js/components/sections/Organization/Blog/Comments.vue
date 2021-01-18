<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Blog<br>
				<div class="h6 mt-1 text-gray-500">Manage the comments on your posts</div>
			</h1>
		</div>
		
		<div class="card shadow mb-4" v-if="comments.length > 0">
			<div class="table-responsive">
				<table class="table table-borderless table-hover">
					<thead>
						<tr>
							<th>Post Title</th>
							<th>Name</th>
							<th>Email</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="comment in comments">
							<td>{{ comment.post.title }}</td>
							<td>{{ comment.name }}</td>
							<td>{{ comment.email }}</td>
							<td>
								<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#viewComment" @click="selectComment(comment)">View Comment</button>
								<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="deleteComment(comment.id)">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- View Comment -->
			<div class="modal fade" id="viewComment" tabindex="-1" role="dialog" aria-labelledby="commentModal" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-primary" id="commentModal">
								Post: <b>{{ selectedComment.post.title }}</b><br>
							</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fas fa-times"></i></span>
							</button>
						</div>
						<div class="modal-body">
							<div v-html="selectedComment.message"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-left-primary shadow h-100 py-2" v-else>
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Comments</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">There are no comments at the moment</div>
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
				comments: [],
				selectedComment: {
					post: {
						title: '',
					}
				},
			}
		},
		methods: {
			fetchComments() {
				const loader = this.$loading.show()
				
				axios.get('/api/blog/comment')
				.then(response => {
					this.comments = response.data
				})
				.catch(err => {
					console.log(err)
				})
				.finally(() => {
	        		loader.hide()
	        	})
			},
			selectComment(comment) {
				this.selectedComment = comment
			},
			deleteComment(id) {
				axios.delete('/api/blog/comment/'+id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Comment was deleted successfully!'
					})

					this.fetchComments()
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
			document.title = 'Manage Comments on Blog | ILA'

			this.fetchComments()
		},
		mounted() {

		}
	}
</script>
