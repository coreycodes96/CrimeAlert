import axios from "axios";

const notifications = {
    namespaced: true,
    state: {
        notifications: []
    },
    getters: {
        //Fetch notification
        fetchNotifications: state => state.notifications
    },
    actions: {
        //Getting notifications
        getNotifications({commit}){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/notifications/get_notifications')
                .then(res => {
                    resolve(res);
                    commit('STORE_NOTIFICATIONS', res.data);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Getting the notification count
        getNotificationCount(){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/notifications/notification_count')
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Mark all the notifications as read
        markAllNotificationsAsRead(){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/notifications/mark_as_read_notifications')
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Delete a notification
        deleteNotification(NULL, id){
            return new Promise((resolve, reject) => {
                axios.delete(`http://192.168.1.114:8000/notifications/delete/notification/${id}`)
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Get a notification
        getNotification({commit}, id){
            return new Promise((resolve, reject) => {
                axios.get(`http://192.168.1.114:8000/notifications/get_notification/${id}`)
                .then(res => {
                    resolve(res);
                    commit('ADD_NOTIFICATION', res.data[0]);
                })
                .catch(error => {
                    reject(error);
                })
            })
        }
    },
    mutations: {
        //Storing notifications
        STORE_NOTIFICATIONS(state, data){
            state.notifications = data;
        },
        //Add a notification
        ADD_NOTIFICATION(state, data){
            state.notifications.unshift(data);
        }
    }
};

export default notifications;