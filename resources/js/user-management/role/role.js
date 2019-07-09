require('./../../vue-assets.js');
Vue.component('role-list', require('./RoleList.vue').default);

const app = new Vue({
	el: '#demo-app'
});