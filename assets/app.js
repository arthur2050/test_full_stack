// assets/js/app.js
import Vue from 'vue';
import Post from './components/Post'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import axios from 'axios'
axios.defaults.baseURL = "http://127.0.0.1:8080/"
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(axios)
Vue.prototype.axios = axios;
/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    components: {Post}
});