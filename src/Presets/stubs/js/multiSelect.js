import Vue from 'vue';

Vue.component('multiselect', require('./components/MultiSelect.component.vue').default);

const app = new Vue({
    el: '#app',
});
