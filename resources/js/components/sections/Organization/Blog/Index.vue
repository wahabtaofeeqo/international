<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {
                    id: '',
                    name: '',
                    email: '',
                    phone_number: '',
                    city: {
                        id: '',
                        name: '',
                        region: {
                            id: '',
                            name: '',
                            country: {
                                id: '',
                                name: '',
                                phone_index: ''
                            }
                        }
                    },
                    role: {
                    	id: '',
                    	name: ''
                    },
                    language: {
                        id: '',
                        name: ''
                    },
                    photo: '',
                    birth_year: '',
                    gender: '',
                    organization_id: '',
                    membership: ''
                },
			}
		},
		methods: {
			getAuthenticatedUser() {
	            axios.get('/api/user')
	            .then(response => {
	                this.user = response.data
	            })
	            .catch(err => {
	                Swal.fire({
	                    type: 'error',
	                    title: 'Something went wrong',
	                    text: 'Please check back later'
	                })
	                .then(() => {
	                    document.location.href = '/'
	                })
	            })
	        },
		},
		created() {
			this.getAuthenticatedUser()
		},
		mounted() {
			$('.sidebar .collapse#blog').addClass('show')
			$('#blogparent').removeClass('collapsed')
			$('#blogparent').parent().addClass('active')
		}
	}
</script>
