/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueCurrencyFilter from 'vue-currency-filter'
import DatePicker from 'vue2-datepicker';
import VueSelect from 'vue-select';
import 'vue2-datepicker/index.css';

Vue.mixin({
	data: function() {
		return {
			get getMonths() {
				let months = [
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July',
					'August',
					'September',
					'October',
					'November',
					'December'
				];
				return months;
			}
		}
	}
});

Vue.use(DatePicker);

Vue.use(VueCurrencyFilter, {
	symbol: "P",
	thousandsSeparator: ",",
	fractionCount: 2,
	fractionSeparator: ".",
	symbolPosition: "front",
	symbolSpacing: true
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('customer-network-component', require('./components/CustomerNetworkComponent.vue').default);
Vue.component('pos-component', require('./components/POSComponent.vue').default);
Vue.component('report-component', require('./components/ReportComponent.vue').default);
Vue.component('commission-component', require('./components/CommissionComponent.vue').default);
Vue.component('payouts-component', require('./components/PayoutsComponent.vue').default);
Vue.component('v-select', VueSelect)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#blackrice_app',
    created: function() {

	}
});
