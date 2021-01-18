<template>
	<div>
		<img class="img-profile rounded-circle" :src="'/public/images/logos/'+this.organization.logo" alt="logo" v-if="organization.logo.length > 15">
		<img class="img-profile rounded-circle" src="https://cdn.arstechnica.net/wp-content/uploads/2016/02/5718897981_10faa45ac3_b-640x624.jpg" alt="logo" v-else>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				organization: {
					name: '',
					logo: ''
				}
			}
		},
		methods: {
			getOrganization() {
                axios.get('/api/organization')
                .then(response => {
                    this.organization = response.data
                })
            },
		},
		created() {
			this.getOrganization()

			Fire.$on('refreshOrganizationProfile', () => {
				this.getOrganization()
			})
		}
	}
</script>
