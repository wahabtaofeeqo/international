<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Membership<br>
				<div class="h6 mt-1 text-gray-500">Users that requested to join your organization</div>
			</h1>
		</div>

		<div class="card shadow h-100 py-2 mb-4" :class="{ 'border-left-primary' : members.length < 1 }" ref="membersContainer">
			<div class="card-body">
				<div v-if="members.length < 1">
					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Membership</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">There are no requests at the moment.</div>
				</div>

				<div class="table-responsive" v-else>
					<table class="table table-striped table-borderless">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Email address</th>
								<th>Phone number</th>
								<th colspan="3">Location</th>
								<th>Action</th>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th>City</th>
								<th>Region</th>
								<th>Country</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(member, index) in members">
								<td>
									<img :src="'/public/images/avatars/'+member.user.photo" alt="dp" width="30" height="30" class="img-profile rounded-circle">
								</td>
								<td>{{ member.user.name }}</td>
								<td>{{ member.user.email }}</td>
								<td>
									<span v-if="member.user.city_id != null">
										+{{ member.user.city.region.country.phone_index }}{{ member.user.phone_number }}
									</span>
								</td>
								<td>
									<span v-if="member.user.city_id != null">
										{{ member.user.city.name }}
									</span>
								</td>
								<td>
									<span v-if="member.user.city_id != null">
										{{ member.user.city.region.name }}
									</span>
								</td>
								<td>
									<span v-if="member.user.city_id != null">
										{{ member.user.city.region.country.name }}
									</span>
								</td>
								<td>
									<button class="btn btn-sm btn-primary shadow" @click="verifyMember(member.id)">
										<i class="mr-2 fas fa-thumbs-up"></i> Verify
									</button>
								</td>
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
				members: [],
			}
		},
		methods: {
			fetchUnverifiedMembers() {
				const loader = this.$loading.show()

				axios.get('/api/organization_members/unverified')
				.then(response => {
					this.members = response.data
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Oops! We cannot fetch the users right now.'
					})

					console.log(err)
				})
				.finally(() => {
	        		loader.hide()
	        	})
			},
			verifyMember(id) {
				const loader = this.$loading.show({
					container: this.$refs.membersContainer
				})

				axios.put('/api/organization_members/' + id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Verification successful!'
					})

					this.fetchUnverifiedMembers()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Verification was unsuccessful!'
					})

					console.log(err)
				})
				.finally(() => {
					loader.hide()
				})
			}
		},
		created() {
			document.title = 'Membership Requests | ILA'

			this.fetchUnverifiedMembers()
		},
		mounted() {

		}
	}
</script>
