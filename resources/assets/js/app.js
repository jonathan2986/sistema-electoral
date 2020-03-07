
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('colegios', require('./components/Colegios.vue'));
Vue.component('recintos', require('./components/Recintos.vue'));
Vue.component('colegios-electorales', require('./components/ColegiosElectorales'));
Vue.component('usuarios', require('./components/Usuarios'));
Vue.component('partidos', require('./components/Partidos'));
Vue.component('candidatos', require('./components/Candidatos'));
Vue.component('roles', require('./components/Roles'));
Vue.component('users', require('./components/Users'));
Vue.component('simpatizantes', require('./components/Simpatizantes'));


const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    }
});
