import axios from "axios";

const comments = {
    namespaced: true,
    state: {
        comments: []
    },
    getters: {
        //Fetch comments
        fetchComments: state => state.comments
    },
    actions: {
        //Get all comments
        getComments({commit}, post_id){
            return new Promise((resolve, reject) => {
                axios.get(`http://192.168.1.114:8000/comments/show/${post_id}`)
                .then(res => {
                    resolve(res.data);
                    commit('SHOW_COMMENTS', res.data)
                })
                .catch(error => {
                    reject(error);
                })
            });
        },
        //Create a comment
        createComment({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/comments/create', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                    commit('STORE_COMMENT', res.data);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },
        //Like a comment
        likeComment({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/comments/like', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    const result = {
                        'commentIndex': data.commentIndex,
                        'res': res.data
                    };

                    commit('LIKE_COMMENT', result);
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        },
        //Unlike a comment
        unlikeComment(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/comments/unlike/${id}`)
                .then(res => {
                    resolve(res.data);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        },
        //delete comment
        deleteComment({commit}, data){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/comments/delete/${data.comment_id}`)
                .then(res => {
                    resolve(res.data);
                    commit('DELETE_COMMENT', data.comment_index);
                })
                .catch(error => {
                    reject(error.response);
                })
            });
        }
    },
    mutations: {
        //Show comments
        SHOW_COMMENTS(state, data){
            state.comments = data;
        },
        //Storing a comment
        STORE_COMMENT(state, data){
            state.comments.unshift(data);
        },
        //Liking a comment
        LIKE_COMMENT(state, data){
            state.comments[data.commentIndex].like_comments.unshift(data.res);
        },
        //Delete a comment
        DELETE_COMMENT(state, data){
            state.comments.splice(data.comment_index, 1);
        }
    }
};

export default comments;