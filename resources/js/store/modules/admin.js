import axios from "axios";

const admin = {
    namespaced: true,
    state: {
        announcements: [],
        users_posts: [],
        users: []
    },
    getters: {
        //Fetch announcements
        fetchAnnouncements: state => state.announcements,

        //Fetch users posts
        fetchUsersPosts: state => state.users_posts,

        //Fetch users
        fetchUsers: state => state.users
    },
    actions: {
        //Getting announcements
        getAnnouncements({commit}){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/admin/announcements')
                .then(res => {
                    resolve(res);
                    commit('SHOW_ANNOUNCEMENTS', res.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Create an announcement
        createAnnouncement({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/admin/create/announcement', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res);
                    commit('STORE_ANNOUNCEMENT', res.data);
                })
                .catch(error => {
                    reject(error);
                });
            })
        },
        //Deleting an announcements
        deleteAnnouncement({commit}, data){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/admin/delete/announcement/${data.id}`)
                .then(res => {
                    resolve(res);
                    commit('REMOVE_ANNOUNCEMENT', data.index);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Getting the users posts
        getUsersPosts({commit}){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/admin/user_posts')
                .then(res => {
                    resolve(res);
                    commit('STORE_USERS_POSTS', res.data);
                })
                .catch(error => {
                    reject(error);
                });
            })
        },
        //Changing the users post status
        changeUsersPostStatus(NULL, id){
            console.log(id);
            return new Promise((resolve, reject) => {
                axios.put('http://192.168.1.114:8000/admin/update/post', id, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Getting the users
        getUsers({commit}){
            return new Promise((resolve, reject) => {
               axios.get('http://192.168.1.114:8000/admin/users')
               .then(res => {
                   resolve(res);
                   commit('STORE_USERS', res.data);
               })
               .catch(error => {
                   reject(error);
               })
            })
        },
        //Deleting a user
        deleteUser(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/admin/delete/users/account/${id}`)
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }
    },
    mutations: {
        //Showing the announcements
        SHOW_ANNOUNCEMENTS(state, data){
            state.announcements = data;
        },
        //Storing an announcement
        STORE_ANNOUNCEMENT(state, data){
            state.announcements.unshift(data);
        },
        //Removing an announcement
        REMOVE_ANNOUNCEMENT(state, data){
            state.announcements.splice(data, 1);
        },
        //Storing users posts
        STORE_USERS_POSTS(state, data){
            state.users_posts = data;
        },
        //Storing users
        STORE_USERS(state, data){
            state.users = data;
        }
    }
};

export default admin;