
require('./bootstrap');

window.Vue = require('vue');

// Form
import { Form } from 'vform';
window.Form = Form;
import { HasError, AlertError, AlertErrors, AlertSuccess } from 'vform'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

// Axios
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

// Sweet Alert
import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});
window.Toast = Toast;

// Overlay loader
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading, {
	loader: 'spinner',
	color: '#115fd5'
});

// event emitter
window.Fire = new Vue();

// Charts
import VueCharts from 'vue-chartjs'

// Text Editor
import tinymce from 'vue-tinymce-editor'
Vue.component('tinymce', tinymce)

// Moment
Vue.use(require('vue-moment'))

// Router
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from './routes'
const router = new VueRouter({ 
	mode: 'history', routes: routes
});

// Alternate components
Vue.component('register', require('./components/Register.vue').default)
Vue.component('profile-navbar', require('./components/nav/Profile.vue').default)
Vue.component('organization-navbar', require('./components/nav/Organization.vue').default)
Vue.component('organization-app', require('./components/pages/organization/Index.vue').default)

const app = new Vue({
    el: '#app',
    router,
    watch: {
		$route(to, from) {
			if (this.$router.currentRoute.path.includes('location')) {
				$('.sidebar .collapse#location').addClass('show')
				$('#locationparent').removeClass('collapsed')
				$('#locationparent').parent().addClass('active')

				$('#membershipparent').parent().removeClass('active')
				$('#settingsparent').parent().removeClass('active')
				$('#newslettersparent').parent().removeClass('active')
				$('#blogparent').parent().removeClass('active')
			}
			else if (this.$router.currentRoute.path.includes('membership')) {
				$('.sidebar .collapse#membership').addClass('show')
				$('#membershipparent').removeClass('collapsed')
				$('#membershipparent').parent().addClass('active')

				$('#locationparent').parent().removeClass('active')
				$('#settingsparent').parent().removeClass('active')
				$('#newslettersparent').parent().removeClass('active')
				$('#blogparent').parent().removeClass('active')
			} 
			else if (this.$router.currentRoute.path.includes('settings')) {
				$('.sidebar .collapse#settings').addClass('show')
				$('#settingsparent').removeClass('collapsed')
				$('#settingsparent').parent().addClass('active')

				$('#locationparent').parent().removeClass('active')
				$('#membershipparent').parent().removeClass('active')
				$('#newslettersparent').parent().removeClass('active')
				$('#blogparent').parent().removeClass('active')
			}
			else if (this.$router.currentRoute.path.includes('newsletters')) {
				$('.sidebar .collapse#newsletters').addClass('show')
				$('#newslettersparent').removeClass('collapsed')
				$('#newslettersparent').parent().addClass('active')

				$('#locationparent').parent().removeClass('active')
				$('#membershipparent').parent().removeClass('active')
				$('#settingsparent').parent().removeClass('active')
				$('#blogparent').parent().removeClass('active')
			}
			else if (this.$router.currentRoute.path.includes('blog')) {
				$('.sidebar .collapse#blog').addClass('show')
				$('#blogparent').removeClass('collapsed')
				$('#blogparent').parent().addClass('active')

				$('#locationparent').parent().removeClass('active')
				$('#membershipparent').parent().removeClass('active')
				$('#settingsparent').parent().removeClass('active')
				$('#newslettersparent').parent().removeClass('active')
			}
			else {
				$('.sidebar .collapse#location').removeClass('show')
				$('#locationparent').addClass('collapsed')
				$('#locationparent').parent().removeClass('active')

				$('.sidebar .collapse#membership').removeClass('show')
				$('#membershipparent').addClass('collapsed')
				$('#membershipparent').parent().removeClass('active')

				$('.sidebar .collapse#settings').removeClass('show')
				$('#settingsparent').addClass('collapsed')
				$('#settingsparent').parent().removeClass('active')

				$('.sidebar .collapse#newsletters').removeClass('show')
				$('#newslettersparent').addClass('collapsed')
				$('#newslettersparent').parent().removeClass('active')

				$('.sidebar .collapse#blog').removeClass('show')
				$('#blogparent').addClass('collapsed')
				$('#blogparent').parent().removeClass('active')
			}
		}
	}
});
