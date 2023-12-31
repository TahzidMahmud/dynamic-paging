
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

window.Vue = require('vue');
// import Vuetify from 'vuetify';
// import 'vuetify/dist/vuetify.min.css';
// Vue.use(Vuetify);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line no-undef
Vue.component('ExampleComponent', require('./components/ExampleComponent.vue'));
const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    // eslint-disable-next-line no-undef
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

// eslint-disable-next-line no-undef
const app = new Vue({
    el: '#app'
});
