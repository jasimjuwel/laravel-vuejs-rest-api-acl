require('./../../vue-assets.js');
Vue.component('change-password', require('./changePasswordForm.vue').default);

const app = new Vue({
	el: '#demo-app'
});