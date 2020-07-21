window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter);

import Dashboard from '../components/Dashboard.vue'
import Pharmacy from '../components/Pharmacy/Pharmacy.vue'
import PharmacySale from '../components/Pharmacy/PharmacySale.vue'
import PatientShow from '../components/PatientShow.vue'
import Revenue from '../components/Revenue.vue'

const routes = [
    { path: '/', component: Dashboard },
    { path: '/pharmacy', component: Pharmacy },
    { path: '/pharmacysale', component: PharmacySale },
    { path: '/patient/:slug',  component: PatientShow },
    { path: '/patient/:slug', name:'PatientShow', component: PatientShow, params:true },
    { path: '/revenue', component: Revenue },
  ];
const router = new VueRouter({
    routes, // short for `routes: routes`
    mode:'history',
    hash: false,
});

// // const originalPush = Router.prototype.push;
// // Router.prototype.push = function push(location) {
// //   return originalPush.call(this, location).catch(err => {
// //     if (err.name !== 'NavigationDuplicated') throw err
// //   });
// }

export default router