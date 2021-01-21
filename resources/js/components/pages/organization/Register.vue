<template>
	<div v-show="user">
		<section class="auth-panel">
	        <div class="container">
	            <div class="card o-hidden border-0 shadow-lg my-5">
	                <div class="card-body p-0">
	                    <div class="row">
	                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

	                        <div class="col-lg-7">
	                            <div class="p-5">
	                            	<div class="text-center mb-3">
										<a :href="'/organization/'+form.organization_id" class="btn btn-default">Return Home</a>
									</div>

									<form class="user" @submit.prevent="registerUser" @keydown="form.onKeydown($event)">
										<div class="form-group">
											<input type="text" class="form-control form-control-user" id="Name" placeholder="Full name" v-model.trim="form.name" :class="{ 'is-invalid': form.errors.has('name') }" required>
											<has-error :form="form" field="name"></has-error>
										</div>
										<div class="form-group">
											<input type="email" class="form-control form-control-user" id="Email" placeholder="Email Address" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" required>
											<has-error :form="form" field="email"></has-error>
										</div>
										<div class="form-group row">
											<div class="col-sm-6 mb-3 mb-sm-0">
												<input type="password" class="form-control form-control-user" id="Password" placeholder="Password" v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" required>
												<has-error :form="form" field="password"></has-error>
											</div>
											<div class="col-sm-6">
												<input type="password" class="form-control form-control-user" id="RepeatPassword" placeholder="Repeat Password" v-model="form.password_confirmation" required>
											</div>
										</div>
										<div class="form-group">
											<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" id="customCheck" v-model="form.subscribed">
												<label class="custom-control-label" for="customCheck">I would like to receive newsletters from ILA</label>
											</div>
										</div>

										<button :disabled="form.busy" type="submit" class="btn btn-primary btn-user btn-block">
											Save and Continue&nbsp;<i class="icon-arrow-right"></i>
										</button>
									</form>

									<hr>

									<form class="user">
										<a href="#" class="btn btn-google btn-user btn-block">
											<i class="icon-google"></i>&nbsp;Register with Google
										</a>
										<a href="#" class="btn btn-facebook btn-user btn-block">
											<i class="icon-facebook"></i>&nbsp;Register with Facebook
										</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: true,

				form: new Form({
					name: '',
					email: '',
					password: '',
					password_confirmation: '',
					subscribed: true,
					organization_id: this.$parent.organization_id || 1
				}),
			}
		},
		methods: {
			checkAuthenticatedUser() {
				axios.get('/api/user')
				.then(() => {
					this.user = false

					Swal.fire({
						type: 'info',
						title: 'Uhmm...',
						text: 'You are authenticated already!'
					})
					.then(() => {
						document.location.href = '/organization/' + this.$parent.organization_id
					})
				})
				.catch(err => {
					console.log(err.response.data.message)
				})
			},
			registerUser() {
				const loader = this.$loading.show({
					container: this.$parent.$refs.registration
				})

				this.form.post('/organization_members/register')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Account created successfully!'
					})

			   		setTimeout(() => {
					    document.location.href = '/register/complete'
					}, 1500)
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Account was not created!'
					})
				})
				.finally(() => {
					loader.hide()
				})
			},
		},
		created() {
			this.checkAuthenticatedUser()
			document.title = 'Member Registration | ILA'
		}
	}
</script>

<style type="text/css" scoped>
	.bg-register-image {
		background-image: url("/master/img/register.jpg");
		background-position: center;
		background-size: cover;
	}
	@media(min-width: 1200px) {
		.auth-panel {
			margin-top: 90px;
		}
	}

</style>
