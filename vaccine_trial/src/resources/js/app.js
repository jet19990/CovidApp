import VueRouter from 'vue-router'

require('./bootstrap');

window.Vue = require('vue');

// Vue progress bar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar,{
    color: '#3498db',
    failedColor:'red',
    height:'3px'
})

/* Sweet alert */
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast =Toast

// gate

import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user)



// Vue router
Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: require('./components/statistics.vue').default 
    },
    {
        path: '/test',
        component: require('./components/account.vue').default 
    },
    {
        path: '/volunteers',
        component: require('./components/volunteers.vue').default 
    },
    {
        path: '/charts',
        component: require('./components/charts.vue').default 
    },
    {
        path: '/docs',
        component: require('./components/documentation.vue').default 
    },
    {
        path: '/api',
        component: require('./components/apiview.vue').default 
    },
    {
        path: '/apirequests',
        component: require('./components/apirequests.vue').default 
    },
    {
        path: '/profile',
        component: require('./components/profile.vue').default 
    }

    
];

Vue.component('thresh-hold', require('./components/threshhold.vue').default)

const router = new VueRouter({
    routes
});


const app = new Vue({
    router,
    el: '#app',
});
