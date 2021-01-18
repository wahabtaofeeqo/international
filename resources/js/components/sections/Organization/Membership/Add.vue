<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">
				Membership<br>
				<div class="h6 mt-1 text-gray-500">Add New Members to the organization.</div>
			</h1>
		</div>

		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-body">
				<form class="user" @submit.prevent="addUser" @keydown="form.onKeydown($event)">
					<div class="form-group row">
						<div class="col-sm-4 mb-3 mb-sm-0">
							<label class="control-label text-primary small" for="name">Full name</label>
							<input type="text" name="name" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name" v-model.trim="form.name" required>
							<has-error :form="form" field="name"></has-error>
						</div>
						<div class="col-sm-4">
							<label class="control-label text-primary small" for="email">Email address</label>
							<input type="email" name="email" id="email" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email address" v-model.trim="form.email" required>
							<has-error :form="form" field="email"></has-error>
						</div>
						<div class="col-sm-4">
							<label class="control-label small text-primary">Year of Birth</label>
                            <input type="number" class="form-control form-control-user" id="BirthYear" placeholder="Year of Birth" min="1900" :max="currentYear" v-model.number="form.birth_year" :class="{ 'is-invalid': form.errors.has('birth_year') }" required>
                            <has-error :form="form" field="birth_year"></has-error>
						</div>
					</div>
					<div class="form-group">
						<div class="row" v-show="locationChooser">
			                <div class="col-sm-4 mb-3 mb-sm-0">
			                	<label class="control-label text-primary small" for="country">Country</label>
			                    <select class="form-control form-control-user custom-select" name="country" id="country" v-model="selectedCountry" @change="handleCountry" :required="locationChooser">
			                        <option value="" disabled>Select a country</option>
			                        <option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
			                    </select>
			                </div>
			                <div class="col-sm-4 mb-3 mb-sm-0">
			                	<label class="control-label text-primary small" for="region">Region</label>
			                    <select class="form-control form-control-user custom-select" name="region" id="region" v-model="selectedRegion" @change="fetchCities" :required="locationChooser">
			                        <option value="" disabled>Select a region</option>
			                        <option :value="region" v-for="region in regions" :key="region.id">{{ region.name }}</option>
			                    </select>
			                </div>
			                <div class="col-sm-4 mb-3 mb-sm-0">
			                	<label class="control-label text-primary small" for="city">City</label>
			                    <select class="form-control form-control-user custom-select" :class="{ 'is-invalid': form.errors.has('city') }" name="city" id="city" v-model="form.city" :required="locationChooser">
			                        <option value="" disabled>Select a city</option>
			                        <option :value="city" v-for="city in cities" :key="city.id">{{ city.name }}</option>
			                    </select>
			                    <has-error :form="form" field="city"></has-error>
			                </div>
			            </div>
			            <div class="custom-control custom-checkbox small">
							<input type="checkbox" class="custom-control-input" id="useOrganizationLocation" v-model="useOrganizationLocation" @change="useOrganizationLocationToggle">
							<label class="custom-control-label" for="useOrganizationLocation">Use your organization's current country, region and city as the user's location</label>
						</div>
		            </div>
		            <div class="form-group">
		            	<label class="control-label text-primary small" for="phone_number">Phone number</label>
		            	<div class="input-group">
		                    <div class="input-group-prepend">
		                        <div class="input-group-text">{{ phone_index }}</div>
		                    </div>
		                    <input type="text" id="phone_number" name="phone_number" v-model.trim="form.phone_number" placeholder="Valid phone number" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('phone_number') }" required>

							 	<label class="custom-control-label" for="useOrganizationLocation">Note: this will be the default password of the user: {{form.phone_number}} </label>
					 
                        </div>
		                <has-error :form="form" field="phone_number"></has-error>
		            </div>
		            <div class="form-group">
		            	<label class="control-label text-primary small" for="language">Language</label>
		            	<select class="form-control form-control-user custom-select" name="language" id="language" v-model="form.language">
		                    <option value="" disabled>Select a language</option>
		                    <option :value="language" v-for="language in languages" :key="language.id">{{ language.name }}</option>
		                </select>
		                <has-error :form="form" field="language"></has-error>
		            </div>
		            <div class="form-group">
		            	<label class="control-label text-primary small" for="gender">Gender</label>
		                <div class="form-inline">
		                    <div class="custom-control custom-radio mr-sm-4">
		                        <input type="radio" name="gender" class="custom-control-input" id="maleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="1" required>
		                        <label class="custom-control-label" for="maleCheck">Male</label>
		                    </div>
		                    <div class="custom-control custom-radio">
		                        <input type="radio" name="gender" class="custom-control-input" id="femaleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="0" required>
		                        <label class="custom-control-label" for="femaleCheck">Female</label>
		                    </div>
		                </div>
		                <has-error :form="form" field="gender"></has-error>
		            </div>

		            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-user btn-block">
		                Add Member
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
				currentYear: new Date().getFullYear(),

				form: new Form({
                    name: '',
                    email: '',
                    phone_number: '',
                    photo: '',
                    birth_year: '',
                    gender: '',
                    city: '',
                    language: '',
				}),

				organization: '',

				languages: [],

                countries: [],
                selectedCountry: '',
                phone_index: '0',

                regions: [],
                selectedRegion: '',

                cities: [],

                useOrganizationLocation: false,
				locationChooser: true,
			}
		},
		methods: {
			getOrganization() {
                axios.get('/api/organization')
                .then(response => {
                	this.organization = response.data
                })
                .catch(err => {
                	Toast.fire({
                		type: 'warning',
                		title: 'We cannot fetch your organization\'s information at this time.'
                	})

                	console.log(err)
                })
            },
            fetchCountries() {
                axios.get('/api/country')
                .then(response => {
                    this.countries = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },
            fetchRegions() {
                axios.get('/api/region/country/'+this.selectedCountry.id)
                .then(response => {
                    this.regions = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of regions ' + err)
                })
            },
            fetchCities() {
                axios.get('/api/city/region/'+this.selectedRegion.id)
                .then(response => {
                    this.cities = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of cities ' + err)
                })
            },
            fetchLanguages() {
                axios.get('/api/language')
                .then(response => {
                    this.languages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
            },
            getPhoneIndex() {
                this.phone_index = this.selectedCountry.phone_index
            },
            handleCountry() {
                this.fetchRegions()
                this.getPhoneIndex()
            },
            useOrganizationLocationToggle() {
            	if (this.useOrganizationLocation) {
            		this.locationChooser = false

            		this.form.city = this.organization.city
            		this.phone_index = this.organization.city.region.country.phone_index
            	} else {
            		this.form.city = ''
            		this.phone_index = '0'
            		this.locationChooser = true
            	}
            },
            addUser() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.post('/api/organization_members')
            	.then(response => {
            		this.form.reset()
            		if (this.useOrganizationLocation) {
            			this.useOrganizationLocation = true
            			this.useOrganizationLocationToggle()
            		}

            		Toast.fire({
            			type: 'success',
            			title: 'Registration successful!'
            		})
            	})
            	.catch(err => {
            		Toast.fire({
            			type: 'error',
            			title: 'Oops! Something is probably wrong'
            		})

            		console.log(err)
            	})
            	.finally(() => {
            		loader.hide()
            	})
            }
		},
		created() {
			document.title = 'Add Member | ILA'
		},
		mounted() {
			this.getOrganization()
			this.fetchCountries()
        	this.fetchLanguages()
		}
	}
</script>
