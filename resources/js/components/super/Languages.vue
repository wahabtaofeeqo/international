<template>
	<div>
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Languages</h1>
		</div>

		<div class="card shadow mb-4" ref="formContainer">
			<div class="card-header py-3">
				<p class="text-primary">{{ edit ? 'Update' : 'Register' }}</p>

				<form class="user" @submit.prevent="edit ? updateLanguage() : registerLanguage()" @keydown="form.onKeydown($event)">
					<div class="form-group">
						<div class="input-group">
							<input type="text" name="" id="name" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('name') }" v-model.trim="form.name" placeholder="Name" required>

							<input type="text" name="" id="code" class="form-control form-control-user" :class="{ 'is-invalid': form.errors.has('code') }" v-model.trim="form.code" placeholder="Code" required>

							<div class="input-group-append">
								<button type="button" name="" class="btn btn-user btn-secondary" v-show="edit" @click="resetForm">Reset</button>
								<input type="submit" name="" class="btn btn-user" :class="!edit ? 'btn-primary' : 'btn-success'" :value="!edit ? 'Add' : 'Update'">
							</div>
						</div>

						<has-error :form="form" field="name"></has-error>
						<has-error :form="form" field="code"></has-error>
					</div>
				</form>
			</div>

			<div class="card-body">
				<div class="small text-danger text-right">Careful with deletes though, all registered entities that use the language will be deleted as well.</div>

				<table class="table table-borderless" v-if="languages.length > 0">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Code</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(language, index) in languages">
							<td>{{ index+1 }}</td>
							<td>{{ language.name }}</td>
							<td>{{ language.code }}</td>
							<td>
								<button class="btn btn-sm btn-primary shadow" @click="editLanguage(language)">Edit</button>
								<button class="btn btn-sm btn-danger shadow" @click="deleteLanguage(language.id)">Delete</button>
							</td>
						</tr>
					</tbody>
				</table>

				<div class="card border-left-primary shadow h-100 py-2" v-else>
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Languages</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">There are no languages here yet.</div>
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
				languages: [],

				form: new Form({
					id: '',
					name: '',
					code: ''
				}),

				edit: false
			}
		},
		methods: {
            fetchLanguages() {
                axios.get('/api/language')
                .then(response => {
                    this.languages = response.data
                })
                .catch(err => {
                    console.log('Could not fetch list of languages ' + err)
                })
            },
            registerLanguage() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.post('/api/language')
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Language Added'
            		})

            		this.fetchLanguages()
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
            editLanguage(language) {
            	this.form.fill(language)

            	this.edit = true
            },
            resetForm() {
            	this.form.reset()
            	this.edit = false
            },
            updateLanguage() {
            	const loader = this.$loading.show({
            		container: this.$refs.formContainer
            	})

            	this.form.put('/api/language/' + this.form.id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Update was succesful'
            		})

            		this.resetForm()
            		this.fetchLanguages()
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
            deleteLanguage(id) {
            	axios.delete('/api/language/' + id)
            	.then(response => {
            		Toast.fire({
            			type: 'success',
            			title: 'Delete was succesful'
            		})

            		this.fetchLanguages()
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
			document.title = 'Languages | ILA'

			this.fetchLanguages()
		},
		mounted () {
			
		},
	}
</script>
