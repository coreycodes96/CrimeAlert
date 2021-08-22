<template>
    <!-- Error Container -->
    <div v-show="text !== ''" ref="errorNotificationRef" class="fixed top-0 left-0 p-2 flex justify-between items-center w-full h-12 bg-red-500 text-white select-none z-30">
        <!-- Error Message -->
        <p><i class="fas fa-exclamation-circle"></i> {{text}}</p>

        <!-- Close Error Message -->
        <i class="fas fa-times text-xl cursor-pointer" @click="closeErrorNotification"></i>
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
        closeErrorNotification(){
            tl.to(this.$refs.errorNotificationRef, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: 'power3.out'});
        }
    },
    mounted(){
        //Waiting for a error message
        bus.$on('error_info', data => {

            //Setting the error message
            this.text = data;

            //Displaying the error notification
            tl.to(this.$refs.errorNotificationRef, {display: 'flex', marginLeft: 0, duration: 0.3, ease: 'power3.out'});

            //After 5 seconds close the error notification
            setTimeout(() => {
                tl.to(this.$refs.errorNotificationRef, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: 'power3.out'});
            }, 5000);
        })
    }
}
</script>