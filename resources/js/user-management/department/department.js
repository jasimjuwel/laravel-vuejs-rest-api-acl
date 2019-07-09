require('./../../vue-assets.js');
Vue.component('department-list', require('./DepartmentList.vue').default);

const app = new Vue({
	el: '#demo-app'
});