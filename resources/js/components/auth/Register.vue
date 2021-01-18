<template>
	<div>
        <a href="/" class="btn btn-default" style="position: absolute; top: 0; margin: auto 35%;">Return Home</a>

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
				Save and Continue&nbsp;<i class="fas fa-arrow-right"></i>
			</button>
		</form>

		<hr>

		<form class="user">
			<a href="#" class="btn btn-google btn-user btn-block">
				<i class="fab fa-google fa-fw"></i> Register with Google
			</a>
			<a href="#" class="btn btn-facebook btn-user btn-block">
				<i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
			</a>
		</form>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: new Form({
					name: '',
					email: '',
					password: '',
					password_confirmation: '',
					subscribed: true,
				}),
			}
		},
		methods: {
			registerUser() {
				const loader = this.$loading.show({
					container: this.$parent.$refs.registration
				})

				this.form.post('/register')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Account created successfully!'
					})
					
			   		setTimeout(() => {
					    this.$router.push({ name: 'CompleteRegistration' })
					}, 1500)
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Account was not created!'
					})

					loader.hide()
				})
				.finally(() => {
					setTimeout(() => {
						loader.hide()
					}, 2500)
				})
			},
		},
		created() {
			this.$parent.title = 'Create an Account!'
		},
		mounted() {
			
		}
	}
</script>