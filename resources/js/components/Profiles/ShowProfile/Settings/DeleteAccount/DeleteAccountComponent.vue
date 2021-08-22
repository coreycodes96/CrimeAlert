<template>
    <div class="flex justify-center items-center flex-col w-full h-500 text-white">
        <!-- Warning message -->
        <p><i class="fas fa-exclamation-circle text-red-500 mb-5"></i> When you press this button your account will be deleted for good!!</p>
        
        <!-- Delete Users Account -->
        <button @click="deleteUserAccount" class="p-3 mx-5 bg-red-500 w-3/6 text-white rounded">Delete Account</button>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../../app';
export default {
    props:{
        loggedInUserId: Number
    },
    methods:{
        ...mapActions('profile', ['deleteAccount']),
        //Making a request to delete the users account
        deleteUserAccount(){
            this.deleteAccount(this.loggedInUserId)
            .then(() => {
                window.location.replace('http://192.168.1.114:8000/login');
            })
            .catch(() => {
                bus.$emit('profile_error')
            })
        }
    }
}
</script>