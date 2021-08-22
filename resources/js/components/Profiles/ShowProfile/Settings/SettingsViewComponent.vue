<template>
    <div>
        <!-- Settings Button -->
        <i v-if="userId === loggedInUserId" @click="openSettingsModal" class="fas fa-user-cog cursor-pointer"></i>

        <!-- Settings Modal -->
        <div ref="settingsModal" class="ml-min-100 fixed top-0 left-0 w-full h-screen bg-indigo-800 z-50">
            <div class="pt-2 px-3 absolute flex justify-between items-center w-full h-auto text-white">
                <i @click="settingCount = 0" class="fas fa-long-arrow-alt-left text-2xl cursor-pointer"></i>
                <i @click="closeSettingsModal" class="fas fa-times text-2xl cursor-pointer"></i>
            </div>
            <div class="w-full h-12"></div>

            <div v-if="settingCount === 0" class="flex justify-center items-center flex-col w-full h-screen">
                <button @click="settingCount = 1" class="mb-4 p-3 bg-white w-5/6 rounded">Change Username</button>
                <button @click="settingCount = 2" class="mb-4 p-3 bg-white w-5/6 rounded">Change Password</button>
                <button @click="settingCount = 3" class="p-3 bg-white w-5/6 rounded">Delete Your Account</button>
            </div>

            <!-- Change Username -->
            <template v-if="settingCount === 1">
                <ChangeUsername :logged-in-user-id="loggedInUserId"/>
            </template>

            <!-- Change Password -->
            <template v-if="settingCount === 2">
                <ChangePassword :logged-in-user-id="loggedInUserId" :logged-in-user-firstname="loggedInUserFirstname" :logged-in-user-surname="loggedInUserSurname" :logged-in-user-username="loggedInUserUsername"/>
            </template>

            <!-- Delete Account -->
            <template v-if="settingCount === 3">
                <DeleteAccount :logged-in-user-id="loggedInUserId"/>
            </template>
        </div>
    </div>
</template>

<script>
import ChangeUsername from './ChangeUsername/ChangeUsernameComponent';
import ChangePassword from './ChangePassword/ChangePasswordComponent';
import DeleteAccount from './DeleteAccount/DeleteAccountComponent';
import {bus} from '../../../../app';
export default {
    components:{ChangeUsername, ChangePassword, DeleteAccount},
    props:{
        userId: Number,
        loggedInUserId: Number,
        loggedInUserFirstname: String,
        loggedInUserSurname: String,
        loggedInUserUsername: String,
    },
    data(){
        return{
            settingCount: 0
        }
    },
    methods:{
        openSettingsModal(){
            tl.to(this.$refs.settingsModal, {marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        closeSettingsModal(){
            this.settingCount = 0;
            tl.to(this.$refs.settingsModal, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
        },
    },
    created(){
        bus.$on('profile_error', () => {
            this.settingCount = 0;
            tl.to(this.$refs.settingsModal, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});   
        });
    }
}
</script>