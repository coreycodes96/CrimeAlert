<template>
    <div>
        <!-- Errors -->
        <Errors/>

        <!-- Loader -->
        <div v-if="loading" class="fixed top-0 left-0 flex justify-center items-center w-full h-screen z-50">
            <div class="p-3 bg-indigo-800 rounded text-white">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </div>

        <!-- No Announcements -->
        <template v-if="!loading && fetchAnnouncements.length === 0">
            <div class="flex justify-center items-center w-full h-500 text-indigo-800 select-none">
                <p class="sm:text-2xl text-xl">There are no announcements as of now!</p>
            </div>
        </template>

        <!-- Announcements -->
        <template v-else>
            <div v-for="(announcement) in fetchAnnouncements" :key="announcement.id">
                <div class="my-20 mx-auto p-3 w-4/5 h-auto bg-indigo-800 text-white sm:rounded rounded-none select-none">
                    <!-- Title -->
                    <div class="flex justify-between items-center w-full h-auto">
                        <h3 class="mb-2">{{announcement.title}}</h3>
                        <div v-if="checkTimeLengthOfAnnouncement(announcement.created_at) === 'new'" class="px-2 bg-red-500 rounded">NEW</div>
                    </div>

                    <!-- Body -->
                    <p class="mb-2 text-base whitespace-pre-line">{{announcement.body}}</p>

                    <!-- Date -->
                    <b>Created: {{timeSince(announcement.created_at)}} ago</b>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import Errors from '../Errors/ErrorNotificationComponent';
import formatDistance from 'date-fns/formatDistance';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../app';
export default {
    components:{Errors},
    data(){
        return{
            loading: false
        }
    },
    methods:{
        ...mapActions('announcements', ['getAnnouncements']),
        //A time more understandable for people
        timeSince(date){
            return formatDistance(new Date(), new Date(date));
        },
        //Checking if the announcement is new
        checkTimeLengthOfAnnouncement(date){
            if(formatDistance(new Date(), new Date(date)).split(' ', 2)[1] === 'minute' || formatDistance(new Date(), new Date(date)).split(' ', 2)[1] === 'minutes' || formatDistance(new Date(), new Date(date)).split(' ', 2)[1] === 'than') return 'new';
        }
    },
    computed:{
        ...mapGetters('announcements', ['fetchAnnouncements'])
    },
    created(){
        //Show the loader
        this.loading = true;

        //Getting the announcements
        this.getAnnouncements()
        .then(() => {
            //Stop showing the loader
            this.loading = false;
        })
        .catch(() => {
            //Stop showing the loader
            this.loading = false;

            //Emit to show there is an error
            bus.$emit('announcement_error');
        })

        //If there is an error then send it to the error component
        bus.$on('announcement_error', () => {
            bus.$emit('error_info', 'There seems to be an error please try again later.');
        })
    }
}
</script>