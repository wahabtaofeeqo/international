<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Membership<br>
				<div class="h6 mt-1 text-gray-500">Members of the organization.</div>
			</h1>
		</div>

		<div class="card shadow h-100 py-2 mb-4" :class="{ 'border-left-primary' : members.length < 1 }" ref="membersContainer">
			<div class="card-body">
				<div v-if="members.length < 1">
					<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Membership</div>
					<div class="h5 mb-0 font-weight-bold text-gray-800">You have no members at the moment.</div>
				</div>

				<div class="table-responsive" v-else>
					<table class="table table-hover table-striped table-borderless">
						<thead>
							<tr>
								<th></th>
								<th>Role</th>
								<th>Name</th>
								<th>Email address</th>
								<th>Phone number</th>
								<th colspan="3">Location</th>
								<th>Actions</th>
							</tr>
							<tr>
								<th></th>
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
								<td class="text-white" :class="{ 'text-info' : member.user.role.name == 'user', 'text-danger' : member.user.role.name == 'admin', 'text-success' : member.user.role.name == 'editor' }">{{ member.user.role.name.toUpperCase() }}</td>
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
									<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" @click="verifyMember(member.id)" v-if="member.user.verified == 0">
										<i class="mr-2 fas fa-thumbs-up"></i> Verify
									</button>
									<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" @click="removeMember(member.id)">
										<i class="mr-2 fas fa-trash"></i> Remove
									</button>
									<button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#promoteModal" @click="populatePromotion(member.user)">
										<i class="mr-2 fas fa-level-up-alt"></i> Promote
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="modal fade" id="promoteModal" tabindex="-1" role="dialog" aria-labelledby="promotionModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-primary" id="promotionModal">
							Change member's role in the organization <i class="fas fa-level-up-alt"></i>
						</h5>
						<button class="close" type="button" data-dismiss="modal" @click="clearSelectedMember" aria-label="Close">
							<span aria-hidden="true"><i class="fas fa-times"></i></span>
						</button>
					</div>
					<div class="modal-body">
						<div class="mb-3 p-3" style="background-color: #efefef;">
							<div class="mb-1">Select the role to change <mark>{{ selectedMember.name }}</mark>'s role</div>

							<div class="form-inline">
                                <div class="custom-control custom-radio mr-sm-4" v-for="role in roles">
                                    <input type="radio" name="role" class="custom-control-input" :id="role.name" v-model="selectedMember.role_id" :value="role.id" :key="role.id" required>
                                    <label class="custom-control-label" :for="role.name">{{ role.name.toUpperCase() }}</label>
                                </div>
                            </div>
						</div>

						<div class="mb-1">
							<h5 class="font-weight-bold">Admin</h5>
							<p>
								Can change all editable parts of the organization, just like you can.
							</p>
						</div>
						<div class="mb-1">
							<h5 class="font-weight-bold">Editors</h5>
							<p>
								Can provide information that is transversal to the organization.
								<ul>
									<li>Work on Blog, but you will have to verify their posts before they can show on your affiliate site.</li>
									<li>Work on Newsletters, but cannot dispatch them.</li>
								</ul>
							</p>
						</div>
						<div class="mb-1">
							<h5 class="font-weight-bold">Users</h5>
							<p>
								Are just members of the organization.
							</p>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" @click="clearSelectedMember">Cancel</button>
						<button class="btn btn-success" type="submit" @click="saveNewUserRole">Save</button>
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
				members: [],

				selectedMember: new Form({
					id: '',
					name: '',
					role_id: ''
				}),

				roles: [
					{
						id: 1,
						name: 'user'
					},
					{
						id: 2,
						name: 'editor'
					},
					{
						id: 3,
						name: 'admin'
					}
				]
			}
		},
		methods: {
			fetchMembers() {
				const loader = this.$loading.show()

				axios.get('/api/organization_members')
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

					this.fetchMembers()
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
			},
			removeMember(id) {
				axios.delete('/api/organization_members/' + id)
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'User has been kicked out of your organization.'
					})

					this.fetchMembers()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Oops! Something went horribly wrong.'
					})

					console.log(err)
				})
			},
			populatePromotion(user) {
				this.selectedMember.fill(user)
			},
			clearSelectedMember() {
				$('#promoteModal').modal('toggle')

				this.selectedMember.reset()
			},
			saveNewUserRole() {
				this.selectedMember.post('/api/organization_members/updateRole')
				.then(response => {
					Toast.fire({
						type: 'success',
						title: 'Member\'s role was changed successfully!',
					})

					this.clearSelectedMember()
					this.fetchMembers()
				})
				.catch(err => {
					Toast.fire({
						type: 'error',
						title: 'Role could not be changed!',
					})

					console.log(err)
				})
			}
		},
		created() {
			document.title = 'Members | ILA'

			this.fetchMembers()
		},
		mounted() {

		}
	}
</script>
