<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Cities</h1>
		</div>

		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-header py-3">
				<p class="text-primary">{{ edit ? 'Update' : 'Register' }}</p>

				<form class="user" @submit.prevent="edit ? updateCity() : registerCity()" @keydown="form.onKeydown($event)">
					<div class="form-group">
						<div class="input-group">
							<select name="country" id="country" class="form-control form-control-user custom-select" v-model="form.country" @change="fetchRegions" required>
								<option value="" disabled>Select a country</option>
								<option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
							</select>

							<!-- <select name="region" id="region" class="form-control form-control-user custom-select" :class="{ 'is-invalid': form.errors.has('region') }" v-model="form.region" required>
								<option value="" disabled>Select a region</option>
								<option :value="region" v-for="region in regions" :key="region.id">{{ region.name }}</option>
							</select> -->

			
							<input type="text" class="form-control form-control-user" id="region" placeholder="Enter Region" v-model="form.region">

							<input type="text" name="" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" v-model.trim="form.name" placeholder="Name" required>

							<div class="input-group-append">
								<button type="button" name="" class="btn btn-user btn-secondary" v-show="edit" @click="resetForm">Reset</button>
								<input type="submit" name="" class="btn btn-user" :class="!edit ? 'btn-primary' : 'btn-success'" :value="!edit ? 'Add' : 'Update'">
							</div>
						</div>

						<has-error :form="form" field="name"></has-error>
						<has-error :form="form" field="region"></has-error>
					</div>
					<div class="form-group" v-show="geocoder">
						<label class="small control-label text-danger">Something went wrong with the API. Please enter the latitude and longitude of {{ form.region }} manually</label>
						<div class="input-group">
							<input type="text" name="" id="latitude" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('latitude') }" v-model.trim="form.latitude" placeholder="Latitude">
							<input type="text" name="" id="longitude" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('longitude') }" v-model.trim="form.longitude" placeholder="Longitude">
						</div>
						
						<has-error :form="form" field="latitude"></has-error>
						<has-error :form="form" field="longitude"></has-error>
					</div>
				</form>
			</div>

			<div class="card-body">
				<div class="small text-danger text-right">Careful with deletes though, all registered entities in that location will be deleted as well.</div>
				
				<div v-if="cities.length > 0">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<!-- <th>Region</th> -->
								<th>Country</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(city, index) in cities">
								<td>{{ index+1 }}</td>
								<td>{{ city.name }}</td>
								<!-- <td v-if="city.region != null">{{ city.region.name }}</td>
								<td v-if="city.region != null"> </td> -->
								<td>{{ city.country.name }}</td>
								<td>
									<button class="btn btn-sm btn-primary shadow" @click="editCity(city)">Edit</button>
									<button class="btn btn-sm btn-danger shadow" @click="deleteCity(city.id)">Delete</button>
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
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cities</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">There are no cities here yet.</div>
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
				cities: [],

				form: new Form({
					id: '',
					name: '',
					latitude: '',
					longitude: '',
					region: '',
					country: ''
				}),

				city: '',

				selectedCountry: '',

				edit: false,
				geocoder: false,

				pagination: {},

				url: "/api/city",
			}
		},
		methods: {

			getCities() {
				
				if (this.city.length > 2) {
					axios.get('/api/cities/' + this.city)
					.then(response => {
						console.log(response);
					})
					.catch(err => {
						console.log(err);
					})
				}
			},

			fetchCountries() {
                axios.get('/api/all-countries')
                .then(response => {
                    this.countries = response.data;
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
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

			fetchRegions() {
                axios.get('/api/region/country/'+this.form.country.id)
                .then(response => {
                    this.regions = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of regions ' + err)
                })
            },

            fetchCities() {
                axios.get(this.url)
                .then(response => {
                    this.cities = response.data.data;
                    this.makePagination(response.data);
                })
                .catch(err => {
                    console.log('Could not fetch list of cities ' + err)
                })
            },

            fetchPaginateWithIndex(pageno) {
                this.url = '/api/city?page='+pageno;
                this.fetchCities();
            },

            registerCity() {
            	if (this.form.latitude == '' || this.form.longitude == '') {
            		const loader = this.$loading.show()

	            	fetch('https://geocode.xyz/' + this.form.region +'?json=1')
	            	.then(response => {
	            		response.json()
	            		.then(value => {
	            			this.form.latitude = value.latt
	            			this.form.longitude = value.longt

	            			this.addCity()
	            		})
	            	})
	            	.catch(err => {
	            		Toast.fire({
	            			type: 'warning',
	            			title: 'API to get the latitude and longitude of the region is running slow'
	            		})

	            		this.geocoder = true
	            	})
	            	.finally(() => {
	            		loader.hide()
	            	})
	            } else {
	            	this.addCity()
	            }
            },
            addCity() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.post('/api/city')
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'City Added'
            		})

            		this.fetchCities()
            		this.form.reset()
            		this.selectedCountry = ''
            		this.geocoder = false
            	})
            	.catch(err => {
            		Toast.fire({
            			type: 'error',
            			title: 'Something went wrong'
            		});

            		console.log(err);
            	})
            	.finally(() => {
            		loader.hide()
            	})
            },
            editCity(city) {
            	
            	this.form.fill(city)

            	this.selectedCountry = city.country
            	this.fetchRegions()
            	this.edit = true
            },
            resetForm() {
            	this.form.reset()
            	this.edit = false
            },
            updateCity() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.put('/api/city/' + this.form.id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Update was succesful'
            		})

            		this.resetForm()
            		this.fetchCities()
            		this.selectedCountry = ''
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

            deleteCity(id) {
            	axios.delete('/api/city/' + id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Delete was succesful'
            		})

            		this.fetchCities()
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
			document.title = 'Cities | ILA'

			this.fetchCountries()
			this.fetchCities()
		},
		mounted() {

		}
	}
</script>
