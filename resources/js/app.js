require('./bootstrap');

import Vue from 'vue';

export const bus = new Vue();

//Headers
Vue.component('guest-header', require('./components/Headers/GuestHeaderComponent.vue').default);
Vue.component('user-header', require('./components/Headers/UserHeaderComponent.vue').default);
Vue.component('admin-header', require('./components/Headers/AdminHeaderComponent.vue').default);

//Account
Vue.component('create-account', require('./components/Auth/CreateAnAccount/CreateAccountComponent.vue').default);
Vue.component('login', require('./components/Auth/Login/LoginComponent.vue').default);

//Announcements
Vue.component('announcements', require('./components/Announcements/AnnouncementsComponent.vue').default);

//Posts
Vue.component('view-posts', require('./components/Posts/PostsViewComponent.vue').default);

//Profiles
Vue.component('user-profile', require('./components/Profiles/ProfileViewComponent.vue').default);

//Notifications
Vue.component('notification-view', require('./components/Notifications/NotificationViewComponent.vue').default);

//Admins
Vue.component('view-admin', require('./components/Admins/AdminViewComponent.vue').default);

import store from './store/index';
const app = new Vue({
    el: '#app',
    store
});
