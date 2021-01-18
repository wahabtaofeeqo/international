<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Subscribers</h1>
		</div>

		<div class="card shadow h-100 py-2 mb-4" :class="{ 'border-left-primary' : subscribers.length < 1 }" ref="subscribersContainer">
			<div class="card-body">
				<div v-if="subscribers.length < 1">
					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Subscribers</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">You have no subscribers at the moment.</div>
				</div>

				<div class="table-responsive" v-else>
					<table class="table table-hover table-striped table-borderless">
						<thead>
							<tr>
								<th>#</th>
								<th>Email address</th>
								<th>Preferred Language</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(subscriber, index) in subscribers">
								<td>{{ index+1 }}</td>
								<td>{{ subscriber.email }}</td>
								<td>{{ subscriber.language.name }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
                organization: {
                	id: '',
                	name: '',
                	slogan: '',
                	address: '',
                	description: '',
                	affiliate: ''
                },

                subscribers: []
			}
		},
		methods: {
	        getOrganizationData() {
	        	axios.get('/api/organization/')
	        	.then(response => {
	        		this.organization = response.data
	        	})
	        	.catch(err => {
	        		console.log('We could not get the organization data ' + err)
	        	})
	        },
	        fetchSubscribers() {
	        	const loader = this.$loading.show()
	        	
	        	axios.get('/api/organization_subscription')
	        	.then(response => {
	        		this.subscribers = response.data
	        	})
	        	.catch(err => {
	        		console.log('Could not fetch the subscribers ' + err)
	        	})
	        	.finally(() => {
	        		loader.hide()
	        	})
	        }
		},
		created() {
			document.title = 'Admin Subscribers | ILA'

			this.getOrganizationData()
			this.fetchSubscribers()
		},
		mounted () {
			
		},
	}
</script>
