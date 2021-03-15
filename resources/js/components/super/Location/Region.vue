<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Regions</h1>
		</div>

		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-header py-3">
				<p class="text-primary">{{ edit ? 'Update' : 'Register' }}</p>

				<form class="user" @submit.prevent="edit ? updateRegion() : registerRegion()" @keydown="form.onKeydown($event)">
					<div class="form-group">
						<div class="input-group">
							<select name="country" id="country" class="form-control form-control-user custom-select" :class="{ 'is-invalid': form.errors.has('country') }" v-model="form.country" required>
								<option value="" disabled>Select a country</option>
								<option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
							</select>

							<input type="text" name="" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" v-model.trim="form.name" placeholder="Name" required>

							<div class="input-group-append">
								<button type="button" name="" class="btn btn-user btn-secondary" v-show="edit" @click="resetForm">Reset</button>
								<input type="submit" name="" class="btn btn-user" :class="!edit ? 'btn-primary' : 'btn-success'" :value="!edit ? 'Add' : 'Update'">
							</div>
						</div>

						<has-error :form="form" field="name"></has-error>
						<has-error :form="form" field="country"></has-error>
					</div>
				</form>
			</div>

			<div class="card-body">
				<div class="small text-danger text-right">Careful with deletes though, all registered entities in that location will be deleted as well.</div>
				
				<div v-if="regions.length > 0">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Country</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(region, index) in regions">
								<td>{{ index+1 }}</td>
								<td>{{ region.name }}</td>
								<!-- <td>{{ region.country.name }}</td> -->
								<td>
									<button class="btn btn-sm btn-primary shadow" @click="editRegion(region)">Edit</button>
									<button class="btn btn-sm btn-danger shadow" @click="deleteRegion(region.id)">Delete</button>
								</td>
							</tr>
						</tbody>
					</table>

					<!-- Pagination -->
					<paginate
						:page-count="pagination.last_page || 0"
						:page-range="5"
						:margin-pages="5"
						:click-handler="fetchPaginateWithIndex"
						:prev-text="'Prev'"
						:next-text="'Next'"
						:container-class="'pagination'"
						:page-class="'page-item'"
						:page-link-class="'page-link'"
						:prev-class="'page-item'"
						:prev-link-class="'page-link'"
						:next-class="'page-item'"
						:next-link-class="'page-link'">
					</paginate>
				</div>

				<div class="card border-left-primary shadow h-100 py-2" v-else>
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Regions</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">There are no regions here yet.</div>
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
				regions: [],

				form: new Form({
					id: '',
					name: '',
					country: ''
				}),

				edit: false,

				pagination: {},

				url: '/api/region',
			}
		},
		methods: {
			fetchCountries() {
                axios.get('/api/all-countries')
                .then(response => {
                    this.countries = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },
			fetchRegions() {
                axios.get(this.url)
                .then(response => {
                    this.regions = response.data.data;
                    this.makePagination(response.data);
                })
                .catch(err => {
                    console.log('Could not fetch list of regions ' + err)
                })
            },

            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                    total_items: data.total,
                };

                this.pagination = pagination;
                //console.log(pagination);
            }, 

            fetchPaginateWithIndex(pageno) {
                this.url = '/api/region?page='+pageno;
                this.fetchRegions();
            },

            registerRegion() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.post('/api/region')
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Region Added'
            		})

            		this.fetchRegions()
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
            editRegion(region) {
            	this.form.fill(region)

            	this.edit = true
            },
            resetForm() {
            	this.form.reset()
            	this.edit = false
            },
            updateRegion() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.put('/api/region/' + this.form.id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Update was succesful'
            		})

            		this.resetForm()
            		this.fetchRegions()
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
            deleteRegion(id) {
            	axios.delete('/api/region/' + id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Delete was succesful'
            		})

            		this.fetchRegions()
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
			document.title = 'Regions | ILA'

			this.fetchCountries()
			this.fetchRegions()
		},
		mounted() {

		}
	}
</script>
