<template>
    <span>
        <!-- Change Users Post Status -->
        <button @click="changeAUsersPostStatus" class="p-2 bg-green-600 text-white rounded">Change Users Post Status</button>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        userPostId: Number
    },
    methods:{
        ...mapActions('admin', ['getUsersPosts', 'changeUsersPostStatus']),
        //Making a request to change the users status
        changeAUsersPostStatus(){
            const data = {
                'id': this.userPostId
            };
            
            this.changeUsersPostStatus(data)
            .then(() => {
                this.getUsersPosts();
            })
            .catch(() => {
                bus.$emit('admin_error');
            })
        }
    }
}
</script>