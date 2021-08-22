import axios from "axios";

const profile = {
    namespaced: true,
    state: {
        profile_information: []
    },
    getters: {
        //Fetch users information
        fetchUserProfileInformation: state => state.profile_information
    },
    actions: {
        //Getting the users information
        getUserProfileInformation({commit}, username){
            return new Promise((resolve, reject) => {
                axios.get(`http://192.168.1.114:8000/profile/get_user_information/${username}`)
                .then(res => {
                    resolve(res);

                    commit('SHOW_USER_PROFILE_INFORMATION', res.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Favourite a profile
        favouriteProfile({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/profile/favourite', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                    commit('STORE_FAVOURITE', res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        },
        //Unfavourite a profile
        unfavouriteProfile(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/profile/unfavourite/${id}`)
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            })
        },
        //Change a username
        changeUsername(NULL, data){
            return new Promise((resolve, reject) => {
                axios.put('http://192.168.1.114:8000/profile/change/username', data, {
                    headers:{
                        'Contact-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Change a password
        changePassword(NULL, data){
            return new Promise((resolve, reject) => {
                axios.put('http://192.168.1.114:8000/profile/change/password', data, {
                    headers:{
                        'Contact-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Delete an account
        deleteAccount(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/profile/delete/account/${id}`)
                .then(res => {
                    resolve(res.data);
                }).catch(error => {
                    reject(error.response);
                })
            })
        }
    },
    mutations: {
        //Show the users profile information
        SHOW_USER_PROFILE_INFORMATION(state, data){
            state.profile_information = data;
        },
        //Store favourite
        STORE_FAVOURITE(state, data){
            state.profile_information[0].favourite.unshift(data);
        }
    }
};

export default profile;