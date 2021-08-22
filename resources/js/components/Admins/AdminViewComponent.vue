<template>
    <div class="mt-20 flex w-full h-500 bg-gray-100 select-none">
        <!-- Errors -->
        <Errors/>

        <!-- SideBar -->
        <div class="p-2 w-80 h-auto bg-indigo-800">
            <button @click="status = 0, search = ''" class="mb-10 p-3 w-full h-12 bg-white text-indigo-800"><i class="fas fa-home"></i></button>
            <button @click="status = 1, search = ''" class="mb-10 p-3 w-full h-12 bg-white text-indigo-800">Announcements</button>
            <button @click="status = 2, search = ''" class="mb-10 p-3 w-full h-12 bg-white text-indigo-800">Update Post Status</button>
            <button @click="status = 3, search = ''" class="p-3 w-full h-12 bg-white text-indigo-800">Delete User</button>
        </div>

        <div class="w-full">
            <!-- Search Box -->
            <div class="w-full h-12 bg-blue-500">
                <input class="pl-2 w-full h-12" type="text" placeholder="Search here..." v-model="search">
            </div>

            <!-- Contents -->
            <div class="w-full h-452 overflow-y-scroll">
                <!-- Welcome -->
                <template v-if="status === 0">
                    <div class="flex justify-center items-center w-full h-452 text-indigo-800">
                        <p class="text-xl">Welcome To The Admin Centre!</p>
                    </div>
                </template>

                <!-- Announcements -->
                <AnnouncementView v-if="status === 1" :search="search"/>

                <!-- Users Posts -->
                <UserPostsView v-if="status === 2" :search="search"/>

                <!-- Users -->
                <UserView v-if="status === 3" :search="search"/>
            </div>
        </div>
    </div>
</template>

<script>
import Errors from './../Errors/ErrorNotificationComponent';
import AnnouncementView from './Announcements/AnnouncementViewComponent';
import UserPostsView from './UserPosts/UserPostsViewComponent';
import UserView from './Users/UsersViewComponent';
import {bus} from '../../app';
export default {
    components:{Errors, AnnouncementView, UserPostsView, UserView},
    data(){
        return{
            status: 0,
            search: ''
        }
    },
    created(){
        //Errors
        bus.$on('admin_error', () => {
            bus.$emit('error_info', 'There seems to be an error please try again later.');
        })
    }
}
</script>