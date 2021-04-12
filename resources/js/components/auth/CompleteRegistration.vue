<template>
    <div>
        <form class="user" @submit.prevent="updateUser" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <span class="text-danger" style="">*</span>
                    <select class="form-control mt-0 form-control-user custom-select" v-model="form.country" @change="handleCountry" required>
                        <option value="" disabled>Select your country</option>
                        <option :value="country" v-for="country in countries" :key="country.id">
                            {{ country.name }}
                        </option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <span class="text-danger">&nbsp;</span>
                    <!-- <select class="form-control form-control-user custom-select" v-model="selectedRegion" @change="fetchCities" required>
                        <option value="" disabled>Select your region</option>
                        <option :value="region" v-for="region in regions" :key="region.id"> {{ region.name }}</option>
                    </select> -->
                    <input type="text" class="form-control form-control-user" id="region" placeholder="Enter Region" v-model="form.region">
                    <!-- <has-error :form="form" field="region"></has-error> -->
                </div>
            </div>
            <div class="form-group row">

                <div class="col-sm-6 mb-3 mb-sm-0 autocomplete">
                    <span class="text-danger" style="">*</span>
                    <input type="text" class="form-control form-control-user" id="city" placeholder="Enter City" v-model="form.city" required @input="getCities($event)" @keydown="onKey($event)">
                    <has-error :form="form" field="city"></has-error>
                </div>

                <div class="col-sm-6">
                    <span class="text-danger">&nbsp;</span>
                    <input type="number" class="form-control form-control-user" id="BirthYear" placeholder="Year of Birth" min="1900" :max="currentYear" v-model.number="form.birth_year" :class="{ 'is-invalid': form.errors.has('birth_year') }">
                    <!-- <has-error :form="form" field="birth_year"></has-error> -->
                </div>
            </div>
            <div class="form-group">
                <select class="form-control form-control-user custom-select" v-model="form.language" :class="{ 'is-invalid': form.errors.has('language') }">
                    <option value="" disabled>Choose a preferred language for information and notifications</option>
                    <option :value="language" v-for="language in languages" :key="language.id">{{ language.name }}</option>
                </select>
                <has-error :form="form" field="language"></has-error>
            </div>

            <div class="form-group d-none" style="display: none;">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ phone_index }}</span>
                    </div>
                    <input type="tel" class="form-control form-control-user" id="PhoneNumber" placeholder="Phone number" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }">
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

            <p class="mb-0 text-danger">*</p>
            <div class="form-group form-inline">
                <div class="custom-control custom-radio mr-sm-4">
                    <input type="radio" name="gender" class="custom-control-input" id="maleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="1" required>
                    <label class="custom-control-label" for="maleCheck">Male</label>
                </div>
                <div class="custom-control custom-radio mr-sm-4">
                    <input type="radio" name="gender" class="custom-control-input" id="femaleCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="2" required>
                    <label class="custom-control-label" for="femaleCheck">Female</label>
                </div>

                <div class="custom-control custom-radio">
                    <input type="radio" name="gender" class="custom-control-input" id="otherCheck" v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" value="0" required>
                    <label class="custom-control-label" for="otherCheck">Other</label>
                </div>
                <has-error :form="form" field="gender"></has-error>
            </div>

            <div class="form-group">
                <label for="question">What Project(s) would you like to be funded by ILA?</label>
                <textarea class="form-control" placeholder="Answer..." name="project" v-model="form.project"></textarea>
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
                    region: '',
                    city: '',
                    country: '',
                    project: '',
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

                focus: -1,
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
                axios.get('/api/all-countries')
                .then(response => {
                    this.countries = response.data;
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

            getCities(e) {
                if (this.form.city.length >= 2) {

                    const url = (this.form.country == '') ? '/api/cities/' + this.form.city : '/api/cities/' + this.form.city + '/' + this.form.country.id;

                    axios.get(url)
                    .then(response => {
                        this.autoComplete(e, response.data);
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

                        // if (current.name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        //     b = "<strong>" + current.name.substr(0, val.length) + "</strong>";
                        //     b.innerHTML += current.name.substr(val.length);
                        //     b.innerHTML += "<input type='hidden' value='" + current.name + "'>";
                        // }


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

            fetchCities() {
                axios.get('/api/city/country/'+this.selectedCountry.id)
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
                this.phone_index = this.form.country.phone_index
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

                this.form.put(this.url + this.user.id)
                .then(response => {
                    console.log(response);
                    Swal.fire({
                        type: 'success',
                        title: 'Your account is now active!',
                        text: 'You will be redirected now'
                    })
                    .then(() => {
                        document.location.href = '/home' 
                    })
                })
                .catch(err => {
                    Toast.fire({
                        type: 'error',
                        title: 'We could not update your data'
                    });

                    console.log(err);
                })
                .finally(() => {
                    loader.hide()
                })
            },
            handleCountry() {
                //this.fetchRegions()
                //this.fetchCities();
                this.getPhoneIndex();
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