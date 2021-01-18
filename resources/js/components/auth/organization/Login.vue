<template>
	<div>
		<form class="form-box" @submit.prevent="login" @keydown="form.onKeydown($event)" ref="formContainer">
			<h3 class="h4 text-black mb-4">Sign In</h3>

			<div class="form-group">
				<input type="email" class="form-control" placeholder="Email Addresss" :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email" required>
				<has-error :form="form" field="email"></has-error>
			</div>

			<div class="form-group">
				<input type="password" class="form-control" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }" v-model="form.password" required>
				<has-error :form="form" field="password"></has-error>
			</div>

			<div class="form-group">
				<input :disabled="form.busy" type="submit" class="btn btn-primary btn-pill" value="Sign up">
			</div>
		</form>
	</div>
</template>

<script>
	export default {
		name: 'login',

		data() {
			return {
				form: new Form({
					email: '',
					password: ''
				})
			}
		},
		methods: {
			login() {
				const loader = this.$loading.show({
					container: this.$refs.formContainer
				})

				this.form.post('/login')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Welcome back!'
					})

					Fire.$emit('loggedIn')
				})
				.catch(err => {
					console.log('Something went wrong. ' + err)
				})
				.finally(() => {
					loader.hide()
				})
			}
		}
	}
</script>