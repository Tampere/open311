
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import "babel-polyfill";
require('./bootstrap');

window.Vue = require('vue');

import Tooltip from 'vue-directive-tooltip';
import 'vue-directive-tooltip/css/index.css';
import Vue2Leaflet from 'vue2-leaflet';
Vue.use(Tooltip);

window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash', message);
};

window.moment = require('moment');
moment.locale('fi');

Vue.component('v-map', Vue2Leaflet.Map);
Vue.component('v-tilelayer', Vue2Leaflet.TileLayer);
Vue.component('v-marker', Vue2Leaflet.Marker);

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('Flash', require('./components/Flash.vue'));
Vue.component('Services', require('./components/Services.vue'));
Vue.component('Requests', require('./components/Requests.vue'));
Vue.component('RequestView', require('./components/RequestView.vue'));
Vue.component('ChartRenderer', require('./components/ChartRenderer.vue'));
Vue.component('MapRenderer', require('./components/MapRenderer.vue'));

Vue.filter('formatTimestamp', function(value, format) {
    if (!value) return '';
    return window.moment(value).format(format);
});

Vue.filter('truncate', function(value, limit) {
    return value.substring(0, limit) + '...';
});

const app = new Vue({
    el: '#app'
});

