<template>
    <div>
        <form class="user" @submit.prevent="updateUser" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <select class="form-control form-control-user custom-select" v-model="selectedCountry" @change="handleCountry" required>
                        <option value="" disabled>Select your country</option>
                        <option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <select class="form-control form-control-user custom-select" v-model="selectedRegion" @change="fetchCities" required>
                        <option value="" disabled>Select your region</option>
                        <option :value="region" v-for="region in regions" :key="region.id"> {{ region.name }}</option>
                    </select>
                    <has-error :form="form" field="region"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <select class="form-control form-control-user custom-select" v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" required>
                        <option value="" disabled>Select your city</option>
                        <option :value="city" v-for="city in cities" :key="city.id">{{ city.name }}</option>
                    </select>
                    <has-error :form="form" field="city"></has-error>
                </div>
                <div class="col-sm-6">
                    <input type="number" class="form-control form-control-user" id="BirthYear" placeholder="Year of Birth" min="1900" :max="currentYear" v-model.number="form.birth_year" :class="{ 'is-invalid': form.errors.has('birth_year') }" required>
                    <has-error :form="form" field="birth_year"></has-error>
                </div>
            </div>
            <div class="form-group">
                <select class="form-control form-control-user custom-select" v-model="form.language" :class="{ 'is-invalid': form.errors.has('language') }" required>
                    <option value="" disabled>Choose a preferred language for information and notifications</option>
                    <option :value="language" v-for="language in languages" :key="language.id">{{ language.name }}</option>
                </select>
                <has-error :form="form" field="language"></has-error>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ phone_index }}</span>
                    </div>
                    <input type="tel" class="form-control form-control-user" id="PhoneNumber" placeholder="Phone number" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" required>
                    <has-error :form="form" field="phone_number"></has-error>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-camera"></i></div>
                    </div>
                    <input type="file" id="photo" name="photo" class="form-control form-control-user" @change="getPhoto" :class="{ 'is-invalid': form.errors.has('photo') }" >
                </div>
                <has-error :form="form" field="photo"></has-error>
            </div>
            <div class="form-group form-inline">
                <div class="custom-control custom-radio mr-sm-4">
                    <input type="radio" name="gender" class="custom-control-input" id="maleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="1" required>
                    <label class="custom-control-label" for="maleCheck">Male</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="gender" class="custom-control-input" id="femaleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="0" required>
                    <label class="custom-control-label" for="femaleCheck">Female</label>
                </div>
                <has-error :form="form" field="gender"></has-error>
            </div>

            <button :disabled="form.busy" type="submit" class="btn btn-primary btn-user btn-block">
                Complete Registration&nbsp;<i class="fas fa-thumbs-up"></i>
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentYear: new Date().getFullYear(),

                form: new Form({
                    birth_year: '',
                    gender: '',
                    photo: '',
                    phone_number: '',
                    language: '',
                    city: '',
                }),

                countries: [],
                selectedCountry: '',

                regions: [],
                selectedRegion: '',

                cities: [],
                phone_index: '...',
                languages: [],

                user: {},
                url: '/api/register/',
            }
        },
        methods: {
            getUser() {
                axios.get(this.url)
                .then(response => {
                    this.fetchCountries()
                    this.fetchLanguages()

                    this.user = response.data
                })
                .catch(err => {
                    console.error(err)
                    // document.location.href = '/register'
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
            getPhoto(e) {
                let file = e.target.files[0];
                var reader = new FileReader();

                if (file['size'] < 1048576 && (file['type'] == 'image/jpeg' || file['type'] == 'image/png' || file['type'] == 'image/jpg')) {
                    reader.onloadend = (file) => {
                        this.form.photo = reader.result;
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
            updateUser() {
                const loader = this.$loading.show({
                    container: this.$parent.$refs.registration
                })

                this.form.put(this.url+this.user.id)
                .then(response => {
                    Swal.fire({
                        type: 'success',
                        title: 'Your account is now active!',
                        text: 'You will be redirected now'
                    })
                    .then(() => {
                        console.error(err)
                        document.location.href = '/home' 
                    })
                })
                .catch(err => {
                    Toast.fire({
                        type: 'error',
                        title: 'We could not update your data'
                    })
                })
                .finally(() => {
                    loader.hide()
                })
            },
            handleCountry() {
                this.fetchRegions()
                this.getPhoneIndex()
            },
        },
        created() {
            this.getUser()

            this.$parent.title = 'Almost done!'
        },
        mounted() {

        }
    }
</script>