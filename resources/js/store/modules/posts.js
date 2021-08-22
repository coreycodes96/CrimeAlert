import axios from "axios";

const posts = {
    namespaced: true,
    state: {
        posts: []
    },
    getters: {
        //Fetch posts
        fetchPosts: state => state.posts
    },
    actions: {
        //Get all posts
        getPosts({commit}, page){
            return new Promise((resolve, reject) => {
                axios.get(`http://192.168.1.114:8000/posts/show?page=${page}`)
                .then(res => {
                    resolve(res.data);
                    commit('SHOW_POSTS', res.data)
                })
                .catch(error => {
                    reject(error);
                })
            });
        },
        //Create a post
        createPost({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/posts/create', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res);
                    commit('STORE_POST', res.data);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },
        //Like a post
        likePost({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/posts/like', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    const result = {
                        'postIndex': data.postIndex,
                        'res': res.data
                    };

                    commit('LIKE_POST', result);
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        },
        //Unlike post
        unlikePost(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/posts/unlike/${id}`)
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        },
        //Delete post
        deletePost({commit}, data){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/posts/delete/${data.post_id}`)
                .then(res => {
                    resolve(res.data);
                    commit('DELETE_POST', data.post_index);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        }
    },
    mutations: {
        //Show posts
        SHOW_POSTS(state, data){
            state.posts = data;
        },
        //Storing a post
        STORE_POST(state, data){
            state.posts.data.unshift(data);
        },
        //Like a post
        LIKE_POST(state, data){
            state.posts.data[data.postIndex].likes.unshift(data.res);
        },
        //Delete a post
        DELETE_POST(state, data){
            state.posts.data.splice(data.post_index, 1);
        }
    }
};

export default posts;