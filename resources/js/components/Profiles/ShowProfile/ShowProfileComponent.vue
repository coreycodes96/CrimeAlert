<template>
    <div class="select-none">
        <!-- Errors -->
        <ErrorNotification/>
        
        <div v-for="user in fetchUserProfileInformation" :key="user.id">
            <!-- Profile Header -->
            <div class="mt-10 mb-4 flex justify-around items-center w-full h-auto text-indigo-800">
                <h3 class="text-xl">{{loggedInUserUsername === user.username ? 'Your' : user.username}} Profile <FavouriteProfile :user-id="loggedInUserId" :profile-id="user.id" :username="username" :favourite="user.favourite"/></h3>
                <SettingsView :user-id="user.id" :logged-in-user-id="loggedInUserId" :logged-in-user-firstname="loggedInUserFirstname" :logged-in-user-surname="loggedInUserSurname" :logged-in-user-username="loggedInUserUsername"/>
            </div>

            <!-- Counts -->
            <div class="flex justify-around items-center w-full h-auto text-indigo-800">
                <p><b>Total Comments:</b> {{user.comment_count}}</p>
                <p><b>Total Likes:</b> {{user.like_count}}</p>
                <p><b>Total Favourites:</b> {{user.favourite_count}}</p>
            </div>

            <!-- Posts -->
            <div v-if="user.post.length === 0" class="p-5 flex justify-center items-center w-full h-96 text-indigo-800 select-none">
                <p class="text-3xl">{{loggedInUserUsername === user.username ? 'You' : user.username}} has no posts</p>
            </div>

            <div v-else v-for="post in user.post" :key="post.id">
                <div class="relative p-5 my-10 sm:mx-auto mx-0 bg-indigo-800 sm:w-4/5 w-full text-white sm:rounded rounded-none select-none">
                    <!-- Image/Video -->
                    <div v-html="displayMedia(post.media)"></div>

                    <!-- Information -->
                    <div>
                        <p class="mt-10 whitespace-pre-line">{{post.body}}</p>
                        <p class="mt-5"><i class="fas fa-location-arrow"></i> {{post.location}}</p>
                        <div v-if="post.user" class="mt-5 flex justify-between items-center w-full h-auto">
                            <p class="mr-5"><i class="fas fa-pen"></i> Created By: {{post.user.username}}</p>
                            <p><i class="fas fa-clock"></i> {{timeSince(post.created_at)}} ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SettingsView from './Settings/SettingsViewComponent';
import FavouriteProfile from './FavouriteProfile/FavouriteProfileComponent';
import formatDistance from 'date-fns/formatDistance';
import ErrorNotification from '../../Errors/ErrorNotificationComponent';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../../app';
export default {
    components:{FavouriteProfile, SettingsView, ErrorNotification},    
    props:{
        loggedInUserId: Number,
        loggedInUserFirstname: String,
        loggedInUserSurname: String,
        loggedInUserUsername: String,
        username: String
    },
    methods:{
        ...mapActions('profile', ['getUserProfileInformation']),
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
        ...mapGetters('profile', ['fetchUserProfileInformation']),
    },
    created(){
        //Errors
        bus.$on('profile_error', () => {
            bus.$emit('error_info', 'There seems to be an error please try again later.');
        });
        
        //Getting the profile information
        this.getUserProfileInformation(this.username)
        .catch(() => {
            bus.$emit('profile_error');
        })
    }
}
</script>