<template>
    <span>
        <!-- Delete an announcement -->
        <i @click="deleteAAnnouncement" class="fas fa-trash text-red-500 cursor-pointer"></i>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        announcementId: Number,
        announcementIndex: Number
    },
    methods:{
        ...mapActions('admin', ['getAnnouncements', 'deleteAnnouncement']),
        //Making a request to delete an announcement
        deleteAAnnouncement(){
            const data = {
                'id': this.announcementId,
                'index': this.announcementIndex
            };

            this.deleteAnnouncement(data)
            .then(() => {
                this.getAnnouncements();
            })
            .catch(() => {
                bus.$emit('admin_error');
            })
        }
    }
}
</script>