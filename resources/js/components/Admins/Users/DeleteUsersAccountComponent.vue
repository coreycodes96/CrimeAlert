<template>
    <span>
        <!-- Delete A User -->
        <button @click="deleteAUsersAccount" class="p-2 bg-red-500 rounded text-white">Delete Account!</button>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        userId: Number
    },
    methods:{
        ...mapActions('admin', ['getUsers', 'deleteUser']),
        //Making a request to delete a users account
        deleteAUsersAccount(){
            this.deleteUser(this.userId)
            .then(() => {
                this.getUsers();
            })
            .catch(() => {
                bus.$emit('admin_error');
            })
        }
    }
}
</script>