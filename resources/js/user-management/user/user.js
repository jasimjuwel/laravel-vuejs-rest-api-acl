require('./../../vue-assets.js');
Vue.component('user-list', require('./UserList.vue').default);

const app = new Vue({
	el: '#demo-app'
});