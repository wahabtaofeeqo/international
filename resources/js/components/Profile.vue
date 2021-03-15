<template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profile Settings</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Details</h6>
                    </div>
                    <div class="card-body" ref="update">
                        <alert-errors :form="form">There were some problems with your input.</alert-errors>

                        <form class="user" @submit.prevent="updateUser" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small" for="name">Full name</label>
                                    <input type="text" id="name" name="name" v-model.trim="form.name" placeholder="Full name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" required>
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label text-primary small" for="email">Email address</label>
                                    <input type="email" id="email" name="email" v-model.trim="form.email" placeholder="Email address" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('email') }" required>
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small" for="country">Country</label>
                                    <select class="form-control form-control-user custom-select" name="country" id="country" @change="fetchRegions" v-model="form.city.country" required>
                                        <option value="" disabled>Select a country</option>
                                        <option :value="country" v-for="country in countries" :key="country.id">{{ country.name }}</option>
                                    </select>
                                    <has-error :form="form" field="city.country"></has-error>
                                </div>

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small" for="region">Region</label>
                                    <!-- <select class="form-control form-control-user custom-select" name="region" id="region" @change="fetchCities" v-model="form.city.region" required>
                                        <option value="" disabled>Select a region</option>
                                        <option :value="region" v-for="region in regions" :key="region.id">{{ region.name }}</option>
                                    </select>
                                    <has-error :form="form" field="city.region"></has-error> -->

                                    <input type="text" class="form-control form-control-user" id="region" placeholder="Enter Region" v-model="form.city.region == null ? ' ' : form.city.region.name">
                                </div>

                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small" for="city">City</label>
                                   <!--  <select class="form-control form-control-user custom-select" :class="{ 'is-invalid': form.errors.has('city') }" name="city" id="city" v-model="form.city" required>
                                        <option value="" disabled>Select a city</option>
                                        <option :value="city" v-for="city in cities" :key="city.id">{{ city.name }}</option>
                                    </select>
                                    <has-error :form="form" field="city.city"></has-error> -->
                                    <input type="text" class="form-control form-control-user" id="city" placeholder="Enter City" v-model="form.city.name" required @input="getCities($event)" @keydown="onKey($event)">
                                    <has-error :form="form" field="city.city"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small" for="phone_number">Phone number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{ form.city.country.phone_index }}</div>
                                        </div>
                                        <input type="text" id="phone_number" name="phone_number" v-model.trim="form.phone_number" placeholder="Valid phone number" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('phone_number') }" required>
                                    </div>
                                    <has-error :form="form" field="phone_number"></has-error>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label text-primary small" for="language">Language to receive information</label>
                                    <select class="form-control form-control-user custom-select" name="language" id="language" v-model="form.language">
                                        <option value="" disabled>Select a language</option>
                                        <option :value="language" v-for="language in languages" :key="language.id">{{ language.name }}</option>
                                    </select>
                                    <has-error :form="form" field="language"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="control-label text-primary small">Photo <span class="small text-danger">(Ignore if you do not want to change your profile picture)</span></label>
                                    <input type="file" id="photo" name="photo" class="form-control form-control-user" @change="getPhoto" :class="{ 'is-invalid': form.errors.has('photo') }">
                                    
                                    <has-error :form="form" field="photo"></has-error>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label small text-primary">Year of Birth</label>
                                    <input type="number" class="form-control form-control-user" id="BirthYear" placeholder="Year of Birth" min="1900" :max="currentYear" v-model.number="form.birth_year" :class="{ 'is-invalid': form.errors.has('birth_year') }" required>
                                    <has-error :form="form" field="birth_year"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label small text-primary">Gender</label>
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

                            <button :disabled="form.busy" type="submit" class="btn btn-success btn-user btn-block">
                                Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Social Profile</h6>
                    </div>
                    <div class="card-body" ref="social">
                        <alert-errors :form="socialForm">There were some problems with your input.</alert-errors>

                        <form class="user" @submit.prevent="updateSocialProfile" @keydown="socialForm.onKeydown($event)">
                            <div class="form-group">
                                <input type="text" name="skype" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('skype') }" id="skype" v-model="socialForm.skype" placeholder="Skype">
                                <has-error :form="socialForm" field="skype"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="facebook" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('facebook') }" id="facebook" v-model="socialForm.facebook" placeholder="Facebook">
                                <has-error :form="socialForm" field="facebook"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="twitter" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('twitter') }" id="twitter" v-model="socialForm.twitter" placeholder="Twitter">
                                <has-error :form="socialForm" field="twitter"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="discord" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('discord') }" id="discord" v-model="socialForm.discord" placeholder="Discord">
                                <has-error :form="socialForm" field="discord"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="slack" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('slack') }" id="slack" v-model="socialForm.slack" placeholder="Slack">
                                <has-error :form="socialForm" field="slack"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="whatsapp" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('whatsapp') }" id="whatsapp" v-model="socialForm.whatsapp" placeholder="WhatsApp">
                                <has-error :form="socialForm" field="whatsapp"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="text" name="linkedin" class="form-control form-control-user" :class="{ 'is-invalid': socialForm.errors.has('linkedin') }" id="linkedin" v-model="socialForm.linkedin" placeholder="Linkedin">
                                <has-error :form="socialForm" field="linkedin"></has-error>
                            </div>

                            <button :disabled="socialForm.busy" type="submit" class="btn btn-primary btn-user btn-block">
                                Update Socials
                            </button>
                        </form>
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
                currentYear: new Date().getFullYear(),

                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    phone_number: '',
                    city: {
                        id: '',
                        name: '',
                        region: {
                            id: '',
                            name: '',
                        },
                        country: {
                            id: '',
                            name: '',
                            phone_index: ''
                        }
                    },
                    language: {
                        id: '',
                        name: ''
                    },
                    photo: '',
                    birth_year: '',
                    gender: ''
                }),

                socialForm: new Form({
                    id: '',
                    skype: '',
                    facebook: '',
                    twitter: '',
                    discord: '',
                    slack: '',
                    whatsapp: '',
                    linkedin: '',
                }),

                languages: [],

                countries: [],

                regions: [],

                cities: [],
            }
        },
        methods: {
            getAuthenticatedUser() {
                axios.get('/api/user')
                .then(response => {

                    this.form.fill(response.data)
                    if (response.data.social_profile) {
                        this.socialForm.fill(response.data.social_profile)
                    }
                })
                .catch(err => {
                    Swal.fire({
                        type: 'error',
                        title: 'Something went wrong',
                        text: 'Please check back later'
                    })
                    .then(() => {
                        document.location.href = '/'
                    })
                })
            },
            fetchCountries() {
                axios.get('/api/all-countries')
                .then(response => {
                    this.countries = response.data
                    //console.log(response);
                    //this.fetchRegions()
                })
                .catch(err => {
                    console.log('Could not fetch list of countries ' + err)
                })
            },

            getCities(e) {
                if (this.form.city.name.length >= 2) {

                    const url = (this.form.country == '') ? '/api/cities/' + this.form.city : '/api/cities/' + this.form.city.name + '/' + this.form.city.country.id;

                    axios.get(url)
                    .then(response => {
                        this.autoComplete(e, response.data);
                        //console.log(response);
                    })
                    .catch(err => {
                        console.log('Could not fetch list of cities ' + err)
                    })
                }
                else {
                    this.closeList();
                }
            },

            autoComplete: function(e, collection) {

                this.closeList();
                if (collection.length == 0) return;

                const input = e.target;
                const wrapper = document.createElement("DIV");
                wrapper.setAttribute("class", "autocomplete-items");

                const component = this;
                e.target.parentNode.appendChild(wrapper);

                if (collection.length > 0) {
                    for (var i = 0; i < collection.length; i++) {

                        const val = this.form.city;
                        let current = collection[i];
                        const item = document.createElement("DIV");

                        item.innerHTML = current.name;
                        item.innerHTML += "<input type='hidden' value='" + current.name + "'>";

                        item.addEventListener("click", function(e) {
                            component.closeList();
                            component.form.city = this.getElementsByTagName("input")[0].value;
                        });

                        wrapper.appendChild(item);
                    }
                }
            },

            closeList: function() {
                const x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    x[i].parentNode.removeChild(x[i]);
                }
            },

            onKey(e) {

                const wrapper = document.getElementsByClassName("autocomplete-items");
                if (wrapper && wrapper.length > 0) {
                    const elements = wrapper[0].getElementsByTagName('div');
                    if (e.keyCode == 40) {
                        this.focus++;
                        this.setActive(elements);
                    }

                    if (e.keyCode == 30) {
                        this.focus--;
                        this.setActive(elements);
                    }

                    if (e.keyCode == 13) {
                        if (this.focus > -1 && elements) {
                            e.preventDefault();
                            elements[this.focus].click();
                        }
                    }
                }
            },

            setActive(elements) {
                this.removeActive(elements);

                if (this.focus >= elements.length) this.focus = 0;
                if (this.focus < 0) this.focus = (elements.length - 1);
                
                elements[this.focus].classList.add("autocomplete-active");
            },

            removeActive(elements) {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove("autocomplete-active");
                }
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
            fetchLanguages() {
                axios.get('/api/language')
                .then(response => {
                    this.languages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
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
                    container: this.$refs.update
                })

                this.form.put('/api/user/'+this.form.id)
                .then(() => {
                    this.getAuthenticatedUser()

                    Toast.fire({
                        type: 'success',
                        title: 'Profile Updated!'
                    })

                    Fire.$emit('refreshProfile')
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
            updateSocialProfile() {
                const loader = this.$loading.show({
                    container: this.$refs.social
                })

                this.socialForm.post('/api/user/social')
                .then(response => {
                    this.getAuthenticatedUser()
                    
                    Toast.fire({
                        type: 'success',
                        title: 'Social profile updated!'
                    })
                })
                .catch(err => {
                    Toast.fire({
                        type: 'error',
                        title: 'Something went wrong'
                    })

                    console.log(err)
                })
                .finally(() => {
                    loader.hide()
                })
            },
        },
        created() {
            document.title = 'User Profile | ILA'

            this.getAuthenticatedUser()
            this.fetchLanguages()
        },
        mounted() {
            setTimeout(() => {this.fetchCountries()}, 1000)
        }
    }
</script>


<style>
    .autocomplete {
      /*the container must be positioned relative:*/
      position: relative;
      display: inline-block;
    }

    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      height: auto;
      max-height: 400px;
      overflow-y: auto;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }

    .autocomplete-items p {
        padding: 10px;
        text-align: center;
    }

    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }

    .autocomplete-items div:hover {
      /*when hovering an item:*/
      background-color: #e9e9e9;
    }

    .autocomplete-active {
      /*when navigating through the items using the arrow keys:*/
      background-color: DodgerBlue !important;
      color: #ffffff;
    }
</style>