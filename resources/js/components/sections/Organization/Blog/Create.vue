<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Blog<br>
				<div class="h6 mt-1 text-gray-500">Create a blog post for your organization's site</div>
			</h1>
		</div>
		
		<div class="card shadow mb-4" ref="formContainer">
			<form class="user" @submit.prevent="create" @keydown="form.onKeydown($event)">
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
						<has-error :form="form" field="content"></has-error>
					</div>

					<div class="form-group">
						<label class="text-primary" for="excerpt">Excerpt</label>
						<input type="text" name="excerpt" class="form-control form-control-user" id="excerpt" :class="{ 'is-invalid': form.errors.has('excerpt') }" placeholder="Short description of the post" v-model.trim="form.excerpt" required>
						<has-error :form="form" field="excerpt"></has-error>
					</div>

					<div class="form-group">
						<label class="text-primary" for="featured_image">Featured Image</label>
						<input type="file" name="featured_image" class="form-control form-control-user" id="featured_image" :class="{ 'is-invalid': form.errors.has('featured_image') }" @change="getImage" required>
						<has-error :form="form" field="featured_image"></has-error>
					</div>

					<div class="form-group" v-if="$parent.user.role.name === 'admin' || $parent.user.role.name === 'super'">
						<div class="custom-control custom-checkbox small">
							<input type="checkbox" class="custom-control-input" id="status" v-model="form.status">
							<label class="custom-control-label" for="status">Publish Immediately</label>
						</div>
					</div>

					<div class="row">
						<button type="submit" class="btn btn-primary btn-user btn-block">Create Post</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: new Form({
					title: '',
					content: '',
					excerpt: '',
					featured_image: '',
					status: false
				}),
			}
		},
		methods: {
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
			create() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/api/blog/post')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Post created!'
					})

					this.form.reset()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Oops',
						text: 'Something went wrong'
					})
				})
				.finally(() => {
					loader.hide()
				})
			},
		},
		created() {
			document.title = 'Create Blog Post | ILA'
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