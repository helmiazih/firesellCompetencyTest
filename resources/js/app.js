require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './components/App'
import VueRouter from 'vue-router';
import routes from './routes';
import EventBus from './event-bus';
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import VueSweetalert2 from 'vue-sweetalert2';
import swal from 'sweetalert';

Vue.use(VueSweetalert2);

const Swal = require('sweetalert2');

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
window.toast = Toast;

Vue.use(EventBus);


Vue.use(VueProgressBar, {
    color: '#55ED11',
    failedColor: 'red',
    height: '5px',
});


Vue.use(BootstrapVue)
Vue.use(VueRouter);

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;

Vue.filter('capitalize', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('created_at', function(date){
    return moment(date).utc([2011, 0, 1, 8]);
});




const app = new Vue({
    el: '#app',

    components: {
        'app': App,
    },
    router: new VueRouter(routes)
});

global.vm = app;
