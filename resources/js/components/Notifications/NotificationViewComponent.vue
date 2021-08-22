<template>
    <div>
        <ShowNotifications/>
    </div>
</template>

<script>
import ShowNotifications from './ShowNotificationsComponent';
import {bus} from '../../app';
import { mapActions } from 'vuex';
export default {
    components: {ShowNotifications},
    props:{
        loggedInUserId: Number,
    },
    methods:{
        ...mapActions('notifications', ['markAllNotificationsAsRead'])
    },
    created(){
        this.markAllNotificationsAsRead();
    }
}
</script>