<template>
    <div>
        <!-- Loader -->
        <template v-if="loading">
            <div class="p-3 flex justify-center items-center w-full h-350 rounded text-indigo-800">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </template>

        <template v-else>
            <!-- No Announcement Results -->
            <div v-if="showAnnouncements.length === 0">
                <div class="flex justify-center items-center w-full h-350 text-indigo-800">
                    <p class="text-xl">No Results :(</p>
                </div>
            </div>

            <!-- Announcement Results -->
            <div v-else v-for="(announcement, announcementIndex) in showAnnouncements" :key="announcement.id">
                <div class="my-10 mx-auto p-2 w-4/5 h-auto bg-indigo-800 text-white">
                    <div class="flex justify-between items-center w-full h-auto">
                        <h2 class="text-xl">{{announcement.title}}</h2>
                        
                        <!-- Delete Announcement -->
                        <DeleteAnnouncement :announcement-id="announcement.id" :announcement-index="announcementIndex"/>
                    </div>
                    <p class="mt-2 text-base whitespace-pre-line">{{announcement.body}}</p>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import DeleteAnnouncement from './DeleteAnnouncementComponent';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../../app';
export default {
    components:{DeleteAnnouncement},
    props:{
        search: String
    },
    data(){
        return{
            loading: false
        }
    },
    methods:{
        ...mapActions('admin', ['getAnnouncements'])
    },
    computed:{
        ...mapGetters('admin', ['fetchAnnouncements']),
        showAnnouncements(){
            //Filter through the data and display the matching results
            const show_announcements = this.fetchAnnouncements.filter(announcement => {
                return Object.values(announcement).some(a => a.toString().toLowerCase().startsWith(this.search.toLowerCase()));
            })

            return show_announcements;
        },
    },
    created(){
        //Letting the user know a request is happening 
        this.loading = true;


        this.getAnnouncements()
        .then(() => {
            //Letting the user the request has a response
            this.loading = false;
        })
        .catch(() => {
            //Letting the user the request has a response
            this.loading = false;

            //Adding an error message
            bus.$emit('admin_error');
        });
    }
}
</script>