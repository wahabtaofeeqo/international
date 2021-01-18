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
			
		},
		created() {
			
		},
		mounted() {
			$('.sidebar .collapse#location').addClass('show')
			$('#locationparent').removeClass('collapsed')
			$('#locationparent').parent().addClass('active')
		}
	}
</script>
