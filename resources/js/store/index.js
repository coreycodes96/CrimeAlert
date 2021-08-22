import Vue from 'vue';
import Vuex from 'vuex';

import account from './modules/account.js';
import announcements from './modules/announcements.js';
import posts from './modules/posts.js';
import comments from './modules/comments.js';
import search from './modules/search.js';
import profile from './modules/profile.js';
import notifications from './modules/notifications.js';
import admin from './modules/admin.js';

Vue.use(Vuex);

export default new Vuex.Store({
	modules:{
		account,
		announcements,
		posts,
		comments,
		search,
		profile,
		notifications,
		admin
	}
});