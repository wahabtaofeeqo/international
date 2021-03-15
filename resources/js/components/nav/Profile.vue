<template>
	<div>
		<span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ user.name }}</span>
		<img class="img-profile rounded-circle" :src="'/images/avatars/'+this.user.photo" alt="photo" v-if="user.photo.length > 15">
		<img class="img-profile rounded-circle" src="https://cdn.arstechnica.net/wp-content/uploads/2016/02/5718897981_10faa45ac3_b-640x624.jpg" alt="photo" v-else>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {
					name: '',
					photo: ''
				}
			}
		},
		methods: {
			getAuthenticatedUser() {
                axios.get('/api/user')
                .then(response => {
                    this.user = response.data
                })
            },
		},
		created() {
			this.getAuthenticatedUser()

			Fire.$on('refreshProfile', () => {
				this.getAuthenticatedUser()
			})
		}
	}
</script>
