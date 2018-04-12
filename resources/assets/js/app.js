
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
//import moment from 'moment';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.moment = require('moment');

Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('app-user', require('./components/user.component.vue'));
Vue.component('app-meal', require('./components/meal.component.vue'));

Vue.filter('dateFormat', (value) => {
   if (value) {
        return moment(String(value)).format('MM/DD/YYYY');
   }
});

Vue.filter('timeFormat', (value) => {
   if (value) {
        return moment(String(value)).format('HH:mm');
   }
});