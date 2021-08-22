<template>
    <div ref="notificationHeader" class="ml-min-100 fixed top-0 left-0 w-full sm:h-12 h-32 bg-indigo-800 text-white border-b-4 border-white z-40 select-none">
        <div class="w-full" v-for="(notification, notificationIndex) in notificationData" :key="notificationIndex">
            <!-- Close Notification Header -->
            <i @click="closeNotification" class="fas fa-times absolute top-2 right-2 cursor-pointer"></i>

            <!-- Favourite Notification -->
            <template v-if="notification.type === 'App\\Notifications\\FavouriteNotification'">
                <div class="flex justify-center items-center w-full sm:h-12 h-32">
                    <p><i class="fas fa-bell mr-2"></i> {{notification.favourite}} has favourited your profile!</p>
                </div>
            </template>

            <!-- Like Post Notification -->
            <template v-if="notification.type === 'App\\Notifications\\LikePostNotification'">
                <div class="flex justify-center items-center w-full sm:h-12 h-32">
                    <p><i class="fas fa-bell mr-2"></i> {{notification.like_post.liker_username}} has liked your post!</p>
                </div>
            </template>

            <!-- Comment Notification -->
            <template v-if="notification.type === 'App\\Notifications\\CommentNotification'">
                <div class="flex justify-center items-center w-full sm:h-12 h-32">
                    <p><i class="fas fa-bell mr-2"></i> {{notification.comment.commenter_username}} has commented on your post!</p>
                </div>
            </template>

            <!-- Like Comment Notification -->
            <template v-if="notification.type === 'App\\Notifications\\LikeCommentNotification'">
                <div class="flex justify-center items-center w-full sm:h-12 h-32">
                    <p><i class="fas fa-bell mr-2"></i> {{notification.like_comment.liker_username}} has liked your comment!</p>
                </div>
            </template>

            <!-- Post Approved Notification -->
            <template v-if="notification.type === 'App\\Notifications\\PostApprovedNotification'">
                <div class="flex justify-center items-center w-full sm:h-12 h-32">
                    <p><i class="fas fa-bell mr-2"></i> Congratulations! Your post has been approved.</p>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../app';
export default {
    props:{
        loggedInUserId: Number
    },
    data(){
        return{
            notificationData: []
        }
    },
    methods:{
        ...mapActions('notifications', ['getNotification']),
        //Close notifications
        closeNotification(){
            tl.to(this.$refs.notificationHeader, {display: 'none', marginLeft: '-100%', duration: 0.4, ease: "power3.out"});
            this.notificationData = [];
        }
    },
    created(){
        //Notification
        Echo.private(`App.Models.User.${this.loggedInUserId}`)
            .notification((notification) => {
                //Add 1 to the notification count
                bus.$emit('notification_count_add');
                
                //Add the new notification to the notification page
                this.getNotification(notification.id);
                
                //Adding the notification to the header
                this.notificationData.unshift(notification);
                
                //Opening the notification header
                tl.to(this.$refs.notificationHeader, {display: 'flex', marginLeft: '0', duration: 0.4, ease: "power3.out"});
                
                //After 7 seconds close the notification header
                setTimeout(() => {
                    tl.to(this.$refs.notificationHeader, {display: 'none', marginLeft: '-100%', duration: 0.4, ease: "power3.out"});
                    this.notificationData = [];
                }, 7000);
            })
    }
}
</script>