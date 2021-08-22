<template>
    <div>
        <!-- Loader -->
        <template v-if="loading">
            <div class="p-3 flex justify-center items-center w-full h-350 rounded text-indigo-800">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </template>

        <template v-else>
            <!-- No Posts Results -->
            <div v-if="showUsersPosts.length === 0">
                <div class="flex justify-center items-center w-full h-350 text-indigo-800">
                    <p class="text-xl">No Results :(</p>
                </div>
            </div>
            
            <!-- Post Results -->
            <div v-else v-for="(user_post) in showUsersPosts" :key="user_post.id">
                <div class="relative p-5 my-10 sm:mx-auto mx-0 bg-indigo-800 sm:w-4/5 w-full text-white sm:rounded rounded-none select-none">
                    <!-- Image/Video -->
                    <div v-html="displayMedia(user_post.media)"></div>

                    <!-- Information -->
                    <div>
                        <p class="mt-10 whitespace-pre-line">{{user_post.body}}</p>
                        <p class="mt-5"><i class="fas fa-location-arrow"></i> {{user_post.location}}</p>
                        <div v-if="user_post.user" class="mt-5 flex justify-between items-center w-full h-auto">
                            <p class="mr-5"><i class="fas fa-pen"></i> Created By: {{user_post.user.username}}</p>
                            <p><i class="fas fa-clock"></i> {{timeSince(user_post.created_at)}} ago</p>
                            <!-- Change A Users Post Status -->
                            <ChangeUsersPostStatus :user-post-id="user_post.id"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import ChangeUsersPostStatus from './ChangeUsersPostStatusComponent';
import formatDistance from 'date-fns/formatDistance';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../../app';
export default {
    components:{ChangeUsersPostStatus},
    props:{
        search: String
    },
    data(){
        return{
            loading: false
        }
    },
    methods:{
        ...mapActions('admin', ['getUsersPosts']),
        //Checking if the user post is a video or an image
        displayMedia(media){
            //file extentions
            const ext = ['png', 'jpeg', 'jpg'];

            if(ext.includes(media.split('.', 2)[1])){
                return `<img class="w-full h-96 bg-white object-contain" src="../storage/${media}" alt="post">`;
            }else{
                return `
                    <video class="relative w-full h-96 bg-white object-contain z-10" controls>
                        <source src="../storage/${media}"/>
                    </video>
                `;
            }
        },
        //Making it easier for the user see the when the post was created
        timeSince(date) {
            return formatDistance(new Date(), new Date(date));
        }
    },
    computed:{
        ...mapGetters('admin', ['fetchUsersPosts']),
        //Filter through the data and display the matching results
        showUsersPosts(){
            //Filter through the data and display the matching results
            const show_users_posts = this.fetchUsersPosts.filter(user_post => {
                return Object.values(user_post).some(u => u.toString().toLowerCase().startsWith(this.search.toLowerCase()));
            })

            return show_users_posts;
        },
    },
    created(){
        //Letting the user know a request is happening 
        this.loading = true;
        this.getUsersPosts()
        .then(() => {
            //Letting the user the request has a response
            this.loading = false;
        })
        .catch(() => {
            //Letting the user the request has a response
            this.loading = false;

            //Adding an error message
            bus.$emit('admin_error');
        })
    }
}
</script>