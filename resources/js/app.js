require('./bootstrap');

window.Vue = require('vue');

// Import from Dependicies
import moment from 'moment';
Vue.filter('myDate', function (date) {
  return moment(date).locale('en-sg').format('LL');
})
Vue.filter('myTime', function (date) {
  return moment(date).locale('en-sg').format('h:mm A');
})
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
import _ from 'lodash'
Vue.prototype._ = new _

// Import from Helpers
import router from './Helpers/router'
import VueProgressBar from './Helpers/VueProgressBar'
import SweetAlert from './Helpers/SweetAlert'
import Gate from './Helpers/Gate'
Vue.prototype.$gate = new Gate(window.user);

// Global Component
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('notification', require('./components/Notification/Notification.vue').default);
Vue.component('booking', require('./components/Notification/BookingNoti.vue').default);
Vue.component('consult', require('./components/Notification/ConsultNoti.vue').default);



window.Fire = new Vue();


const app = new Vue({
    el: '#app',
    router,
    // data(){
    //   return{
    //     search: ''
    //   }
    // },
    // methods:{
    //   searchit: _.debounce(() => {
    //     Fire.$emit('searching')
    //   }, 1000)
    // }
});

