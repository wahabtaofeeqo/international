<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Countries</h1>
		</div>

		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-header py-3">
				<p class="text-primary">{{ edit ? 'Update' : 'Register' }}</p>

				<form class="user" @submit.prevent="edit ? updateCountry() : registerCountry()" @keydown="form.onKeydown($event)">
					<div class="form-group">
						<div class="input-group">
							<input type="text" name="" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" v-model.trim="form.name" placeholder="Name" required>

							<input type="number" name="" id="phone_index" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('phone_index') }" v-model.number="form.phone_index" placeholder="Phone Index" required>

							<div class="input-group-append">
								<button type="button" name="" class="btn btn-user btn-secondary" v-show="edit" @click="resetForm">Reset</button>
								<input type="submit" name="" class="btn btn-user" :class="!edit ? 'btn-primary' : 'btn-success'" :value="!edit ? 'Add' : 'Update'">
							</div>
						</div>

						<has-error :form="form" field="name"></has-error>
						<has-error :form="form" field="phone_index"></has-error>
					</div>
				</form>
			</div>

			<div class="card-body">
				<div class="small text-danger text-right">Careful with deletes though, all registered entities in that location will be deleted as well.</div>
				<table class="table table-borderless" v-if="countries.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Phone Index</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(country, index) in countries">
							<td>{{ index+1 }}</td>
							<td>{{ country.name }}</td>
							<td>{{ country.phone_index }}</td>
							<td>
								<button class="btn btn-sm btn-primary shadow" @click="editCountry(country)">Edit</button>
								<button class="btn btn-sm btn-danger shadow" @click="deleteCountry(country.id)">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="card border-left-primary shadow h-100 py-2" v-else>
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Countries</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">There are no countries here yet.</div>
							</div>
						</div>
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
				countries: [],

				form: new Form({
					id: '',
					name: '',
					phone_index: ''
				}),

				edit: false
			}
		},
		methods: {
			fetchCountries() {
                axios.get('/api/country')
                .then(response => {
                    this.countries = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },
            registerCountry() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.post('/api/country')
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Country Added'
            		})

            		this.fetchCountries()
            		this.form.reset()
            	})
            	.catch(err => {
            		Toast.fire({
            			type: 'error',
            			title: 'Something went wrong'
            		})
            	})
            	.finally(() => {
            		loader.hide()
            	})
            },
            editCountry(country) {
            	this.form.fill(country)

            	this.edit = true
            },
            resetForm() {
            	this.form.reset()
            	this.edit = false
            },
            updateCountry() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.put('/api/country/' + this.form.id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Update was succesful'
            		})

            		this.resetForm()
            		this.fetchCountries()
            	})
            	.catch(err => {
            		Toast.fire({
            			type: 'error',
            			title: 'Something went wrong'
            		})
            	})
            	.finally(() => {
            		loader.hide()
            	})
            },
            deleteCountry(id) {
            	axios.delete('/api/country/' + id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Delete was succesful'
            		})

            		this.fetchCountries()
            	})
            	.catch(err => {
            		Toast.fire({
            			type: 'error',
            			title: 'Something went wrong'
            		})
            	})
            }
		},
		created() {
			document.title = 'Countries | ILA'

			this.fetchCountries()
		},
		mounted() {

		}
	}
</script>
