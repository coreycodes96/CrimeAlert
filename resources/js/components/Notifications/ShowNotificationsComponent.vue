<template>
    <div class="sm:mx-10 mx-0 select-none">
        <!-- Errors -->
        <Errors/>

        <!-- Loader -->
        <div v-if="loading" class="fixed top-0 left-0 flex justify-center items-center w-full h-screen z-50">
            <div class="p-3 bg-indigo-800 rounded text-white">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </div>

        <!-- No Notifications -->
        <template v-if="!loading && viewFetchNotifications.length === 0">
            <div class="flex justify-center items-center w-full h-500 text-indigo-800">
                <p class="sm:text-2xl text-xl">No notifications :(</p>
            </div>
        </template>

        <!-- Display Notifications -->
        <div v-else v-for="(notification) in viewFetchNotifications" :key="notification.key">
            <div class="relative my-10 p-3 w-full h-auto bg-indigo-800 text-white sm:rounded rounded-none">
                <!-- Delete A Notification -->
                <div class="absolute top-1 right-3">
                    <DeleteNotification :notification-id="notification.id"/>
                </div>
                
                <!-- Favourite Notification -->
                <template v-if="notification.type === 'App\\Notifications\\FavouriteNotification'">
                    <p><a :href="`http://192.168.1.114:8000/profile/${notification.data.favourite}`"><b>{{notification.data.favourite}}</b></a> has favourited your profile!</p>
                </template>

                <!-- Like Post Notification -->
                <template v-if="notification.type === 'App\\Notifications\\LikePostNotification'">
                    <p v-if="notification.data.like_post.liker_username" class="mb-2"><a :href="`http://192.168.1.114:8000/profile/${notification.data.like_post.liker_username}`"><b>{{notification.data.like_post.liker_username}}</b></a> has liked your post!</p>
                    <p class="truncate"><b>Post</b>: {{notification.data.like_post.post_body}} </p>
                </template>

                <!-- Comment Notification -->
                <template v-if="notification.type === 'App\\Notifications\\CommentNotification'">
                    <p class="mb-2"><a :href="`http://192.168.1.114:8000/profile/${notification.data.comment.commenter_username}`"><b>{{notification.data.comment.commenter_username}}</b></a> has commented on your post!</p>
                    <p class="truncate"><b>Post</b>: {{notification.data.comment.post_body}}</p>
                </template>

                <!-- Like Comment Notification -->
                <template v-if="notification.type === 'App\\Notifications\\LikeCommentNotification'">
                    <p class="mb-2"><a :href="`http://192.168.1.114:8000/profile/${notification.data.like_comment.liker_username}`"><b>{{notification.data.like_comment.liker_username}}</b></a> has liked your comment!</p>
                    <p class="truncate"><b>Comment</b>: {{notification.data.like_comment.comment_body}}</p>
                </template>


                <!-- Post Approved Notification -->
                <template v-if="notification.type === 'App\\Notifications\\PostApprovedNotification'">
                    <p class="mb-2"><b>Congratulations your post has been approved!</b></p>
                    <p class="truncate"><b>Post</b>: {{notification.data.post_approved.post_body}}</p>
                </template>

                <!-- Notification Created At -->
                <span class="text-sm">{{timeSince(notification.created_at)}} ago</span>
            </div>
        </div>
    </div>
</template>

<script>
import Errors from './../Errors/ErrorNotificationComponent';
import DeleteNotification from './DeleteNotificationComponent';
import formatDistance from 'date-fns/formatDistance';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../app';
export default {
    components:{Errors, DeleteNotification},
    data(){
        return{        
            loading: false
        }
    },
    methods:{
        ...mapActions('notifications', ['getNotifications']),
        //Making it easier for the user see the when the post was created
        timeSince(date) {
            return formatDistance(new Date(), new Date(date));
        }
    },
    computed:{
        ...mapGetters('notifications', ['fetchNotifications']),
        //Mapping through the data and checking what data needs to be parsed
        viewFetchNotifications(){
            const notfications = this.fetchNotifications.map(n => {
                return {
                    'created_at': n.created_at,
                    'data': typeof n.data === 'string' ? JSON.parse(n.data) : n.data,
                    'id': n.id,
                    'notifiable_id': n.notifiable_id,
                    'notifiable_type': n.notifiable_type,
                    'read_at': n.read_at,
                    'type': n.type,
                    'updated_at': n.updated_at
                };
            });

            return notfications;
        }
    },
    created(){
        //Errors
        bus.$on('notification_error', () => {
            bus.$emit('error_info', 'There seems to be an error please try again later.');
        })

        //Letting the user know a request is happening
        this.loading = true;
        this.getNotifications()
        .then(() => {
            //Letting the user the request has a response
            this.loading = false;
        })
        .catch(() => {
            bus.$emit('notification_error');
        })
    }
}
</script>