<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Messages</h1>
		</div>

		<div v-if="messages.length < 1" class="card shadow h-100 py-2 mb-4 border-left-primary">
			<div class="card-body">
				<div>
					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Messages</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">You have no messages at the moment.</div>
				</div>
			</div>
		</div>

		<div class="row" v-else>
			<div class="col-lg-4" v-for="(message, index) in messages">
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-danger">{{ message.subject }}</h6>
						<div class="dropdown no-arrow">
							<a class="dropdown-toggle" :id="'messageOption'+index" role="button" aria-expanded="false" aria-haspopup="true" href="#" data-toggle="dropdown">
								<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" :aria-labelledby="'messageOption'+index" style="left: 0px; top: 0px; position: absolute; transform: translate3d(17px, 19px, 0px);" x-placement="bottom-end">
								<button class="dropdown-item" @click="resolveMessage(message.id)">Resolve</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<p style="white-space: pre-line;">{{ message.message }}</p>
					</div>
					<div class="card-footer">
						By: <span class="text-primary">{{ message.name }}</span> <br>
						<span class="small">{{ message.email }}</span>
					</div>
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

                messages: []
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
	        fetchMessages() {
	        	const loader = this.$loading.show()

	        	axios.get('/api/organization_contact_message')
	        	.then(response => {
	        		this.messages = response.data
	        	})
	        	.catch(err => {
	        		console.log('Could not fetch the messages ' + err)
	        	})
	        	.finally(() => {
	        		loader.hide()
	        	})
	        },
	        resolveMessage(id) {
	        	axios.delete('/api/organization_contact_message/' + id)
	        	.then(response => {
	        		this.fetchMessages()
	        		
	        		Toast.fire({
	        			type: 'success',
	        			title: 'Message resolved'
	        		})
	        	})
	        	.catch(err => {
	        		console.log('Cannot be resolved at the moment. ' + err)
	        	})
	        }
		},
		created() {
			document.title = 'Admin Messages | ILA'

			this.getOrganizationData()
			this.fetchMessages()
		},
		mounted () {
			
		},
	}
</script>
