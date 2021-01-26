<template>
	<footer class="footer-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<img :src="'/images/logos/'+$parent.organization.logo" alt="logo" width="75" height="75" class="img-fluid mb-3">

					<h3>About {{ $parent.organization.name }}</h3>
					<p>{{ $parent.organization.slogan }}</p>
					<p>
						<i class="icon-map mr-3"></i>
						{{ $parent.organization.address }}, {{ $parent.organization.city.name }}, {{ $parent.organization.city.region.name }}, {{ $parent.organization.city.region.country.name }}
					</p>
				</div>

				<div class="col-md-8 ml-auto" ref="subscription">
					<h3>Subscribe</h3>
					<p>Receive newsletters from us in your preferred language.</p>

					<alert-success :form="subscriptionForm">Thank you subscribing to our platform.</alert-success>

					<form class="footer-subscribe" @submit.prevent="subscribe" @keydown="subscriptionForm.onKeydown($event)">
						<div class="d-flex mb-0">
							<input type="email" class="form-control rounded-0" placeholder="Email" :class="{ 'is-invalid': subscriptionForm.errors.has('email') }" v-model.trim="subscriptionForm.email" required>
							<select class="form-control rounded-0" :class="{ 'is-invalid': subscriptionForm.errors.has('language_id') }" v-model="subscriptionForm.language_id" required>
								<option value="" disabled>Select a language</option>
								<option :value="language.id" v-for="language in languages">{{ language.name }}</option>
							</select>

							<input type="submit" class="btn btn-primary rounded-0" value="Subscribe" :disabled="subscriptionForm.busy">
						</div>
						<has-error :form="subscriptionForm" field="email"></has-error>
					</form>
				</div>
			</div>

			<div class="row pt-5 mt-5 text-center">
				<div class="col-md-12">
					<div class="border-top pt-5">
						<p>
							Copyright &copy; <a href="/">ILA</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
</template>

<script>
	export default {
		data() {
			return {
				languages: [],

				subscriptionForm: new Form({
					email: '',
					language_id: '',
					organization_id: ''
				}),
			}
		},
		methods: {
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
				this.subscriptionForm.organization_id = this.$parent.organization.id

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
		},
		created() {
			this.fetchLanguages()
		},
		mounted() {

		}
	}
</script>
