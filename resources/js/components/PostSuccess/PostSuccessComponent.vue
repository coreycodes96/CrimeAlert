<template>
    <!-- Post Success Container -->
    <div v-show="text !== ''" ref="successNotificationRef" class="fixed top-0 left-0 p-2 flex justify-between items-center w-full h-12 bg-green-500 text-white select-none z-30">
        <!-- Success Message -->
        <p><i class="fas fa-check-circle"></i> {{text}}</p>

        <!-- Close Success Message -->
        <i class="fas fa-times text-xl cursor-pointer" @click="closeSuccessNotification"></i>
    </div>
</template>

<script>
import {bus} from '../../app';
export default {
    data(){
        return {
            text: ''
        }
    },
    methods:{
        //Close error notification
        closeSuccessNotification(){
            tl.to(this.$refs.successNotificationRef, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: 'power3.out'});
        }
    },
    mounted(){
        //Waiting for a success message
        bus.$on('success_info', data => {

            //Setting the success message
            this.text = data;

            //Displaying the success notification
            tl.to(this.$refs.successNotificationRef, {display: 'flex', marginLeft: 0, duration: 0.3, ease: 'power3.out'});

            //After 5 seconds close the success notification
            setTimeout(() => {
                tl.to(this.$refs.successNotificationRef, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: 'power3.out'});
            }, 5000);
        })
    }
}
</script>