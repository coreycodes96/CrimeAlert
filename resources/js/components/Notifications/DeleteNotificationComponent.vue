<template>
    <span>
        <!-- Delete A Notification -->
        <i @click="deleteANotification" class="fas fa-times cursor-pointer"></i>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../app';
export default {
    props:{
        notificationId: String
    },
    methods:{
        ...mapActions('notifications', ['getNotifications', 'deleteNotification']),
        //Making a request to delete a notification
        deleteANotification(){
            this.deleteNotification(this.notificationId)
            .then(() => {
                this.getNotifications();
            })
            .catch(() => {
                bus.$emit('notification_error');
            })
        }
    }
}
</script>