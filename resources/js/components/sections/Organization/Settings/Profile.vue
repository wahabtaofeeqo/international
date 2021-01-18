<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Settings<br>
				<div class="h6 mt-1 text-gray-500">Edit the details of your organization.</div>
			</h1>
		</div>

		<!-- Form -->
		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-body">
				<form class="user" @submit.prevent="updateOrganization" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label text-primary small" for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name of the organization" v-model="form.name" required>
						<has-error :form="form" field="name"></has-error>
					</div>
					<div class="form-group">
						<label class="control-label text-primary small" for="slogan">Slogan</label>
						<input type="text" name="slogan" id="slogan" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('slogan') }" placeholder="Your slogan" v-model="form.slogan" required>
						<has-error :form="form" field="slogan"></has-error>
					</div>
					<div class="form-group">
						<label class="control-label text-primary small" for="description">Description</label>
						<input type="text" name="description" id="description" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('description') }" placeholder="Write a brief introduction about your organization" v-model="form.description" required>
						<has-error :form="form" field="description"></has-error>
					</div>
					<div class="form-group">
						<label class="control-label text-primary small" for="address">Address</label>
						<input type="text" name="address" id="address" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('address') }" placeholder="Headquarters of the organization" v-model="form.address" required>
						<has-error :form="form" field="address"></has-error>
					</div>
					<div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label class="control-label text-primary small" for="country">Country</label>
                            <select class="form-control form-control-user custom-select" name="country" id="country" @change="fetchRegions" v-model="form.city.region.country" required>
                                <option value="" disabled>Select a country</option>
                                <option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
                            </select>
                            <has-error :form="form" field="city.region.country"></has-error>
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label class="control-label text-primary small" for="region">Region</label>
                            <select class="form-control form-control-user custom-select" name="region" id="region" @change="fetchCities" v-model="form.city.region" required>
                                <option value="" disabled>Select a region</option>
                                <option :value="region" v-for="region in regions" :key="region.id">{{ region.name }}</option>
                            </select>
                            <has-error :form="form" field="city.region"></has-error>
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label class="control-label text-primary small" for="city">City</label>
                            <select class="form-control form-control-user custom-select" :class="{ 'is-invalid': form.errors.has('city') }" name="city" id="city" v-model="form.city" required>
                                <option value="" disabled>Select a city</option>
                                <option :value="city" v-for="city in cities" :key="city.id">{{ city.name }}</option>
                            </select>
                            <has-error :form="form" field="city.city"></has-error>
                        </div>
                    </div>
					<div class="form-group">
		                <label class="control-label text-primary small">Logo <span class="text-danger">(Ignore if you do not wish to change it)</span></label>
		                <div class="input-group">
		                    <div class="input-group-prepend" title="Logo">
		                        <div class="input-group-text"><i class="fas fa-image"></i></div>
		                    </div>
		                    <input type="file" id="logo" name="logo" class="form-control form-control-user" @change="getPhoto" :class="{ 'is-invalid': form.errors.has('logo') }">
		                </div>
		                <has-error :form="form" field="logo"></has-error>
		            </div>

		            <button :disabled="form.busy" type="submit" class="btn btn-success btn-user btn-block">
		                Update Organization
		            </button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: new Form({
					id: '',
	                name: '',
	                slogan: '',
	                description: '',
	                address: '',
	                logo: '',
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
                    language: {
                        id: '',
                        name: ''
                    },
                    affiliate: ''
				}),

				countries: [],

                regions: [],

                cities: [],
			}
		},
		methods: {
			getOrganization() {
                axios.get('/api/organization')
                .then(response => {
                    this.form.fill(response.data)
                })
                .catch(err => {
                    Swal.fire({
                        type: 'error',
                        title: 'Something went wrong',
                        text: 'Please check back later'
                    })
                })
			},
			fetchCountries() {
                axios.get('/api/country')
                .then(response => {
                    this.countries = response.data

                    this.fetchRegions()
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },
            fetchRegions() {
                axios.get('/api/region/country/'+this.form.city.region.country.id)
                .then(response => {
                    this.regions = response.data

                    this.fetchCities()
                })
                .catch(err => {
                    console.log('Could not fetch list of regions ' + err)
                })
            },
            fetchCities() {
                axios.get('/api/city/region/'+this.form.city.region.id)
                .then(response => {
                    this.cities = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of cities ' + err)
                })
            },
            getPhoto(e) {
                let file = e.target.files[0];
                var reader = new FileReader();

                if (file['size'] < 1048576 && (file['type'] == 'image/jpeg' || file['type'] == 'image/png' || file['type'] == 'image/jpg')) {
                    reader.onloadend = (file) => {
                        this.form.logo = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    Swal.fire(
                        'Oops...',
                        'Please check the format (JPEG, JPG, PNG) and size (< 1MB) of the image.',
                        'error'
                    )
                }
            },
            updateOrganization() {
                const loader = this.$loading.show({
                    container: this.$refs.formContainer
                })

                this.form.put('/api/organization/'+this.form.id)
                .then(() => {
                    this.getOrganization()

                    Toast.fire({
                        type: 'success',
                        title: 'Organization Profile Updated!'
                    })

                    Fire.$emit('refreshOrganizationProfile')
                })
                .catch(() => {
                    Toast.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong'
                    })
                })
                .finally(() => {
                    loader.hide()
                })
            },
		},
		created() {
			document.title = 'Organization Profile | ILA'

			this.getOrganization()
		},
		mounted() {
            setTimeout(() => {
            	this.fetchCountries()
            }, 1000)
        }
	}
</script>
