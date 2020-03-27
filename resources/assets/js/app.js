
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('colegios', require('./components/Colegios.vue'));
Vue.component('recintos', require('./components/Recintos.vue'));
Vue.component('usuarios', require('./components/Usuarios'));
Vue.component('electores', require('./components/Electores'));
Vue.component('partidos', require('./components/Partidos'));
Vue.component('candidatos', require('./components/Candidatos'));
Vue.component('votos', require('./components/Votos'));
Vue.component('roles', require('./components/Roles'));
Vue.component('users', require('./components/Users'));
Vue.component('simpatizantes', require('./components/Simpatizantes'));
Vue.component('provincias', require('./components/Provincia'));
Vue.component('circunscripcion', require('./components/Circunscripcion'));
Vue.component('municipio', require('./components/Municipio'));
Vue.component('distritos', require('./components/Distritos'));
Vue.component('colegios-electorales', require('./components/ColegiosElectorales'));
Vue.component('v-select', vSelect)

const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    }
});
