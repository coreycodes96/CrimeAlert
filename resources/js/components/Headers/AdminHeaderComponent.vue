<template>
    <div>
        <!-- Header -->
        <div class="sm:p-0 p-3 fixed top-0 left-0 sm:flex block text-center justify-around items-center w-full sm:h-12 h-auto bg-indigo-800 border-b-4 border-white text-white select-none z-20">
            <!-- Title -->
            <h1 class="text-xl sm:text-xl text-2xl">CrimeAlert</h1>

            <!-- Menu -->
            <div class="flex list-none">
                <li class="mt-2 mx-auto flex" @click="openMenu"><i class="fas fa-bars text-xl cursor-pointer"></i></li>
            </div>
        </div>
        <div class="w-full sm:h-12 h-32"></div>

        <!-- Header Modal -->
        <div ref="adminMenu" class="ml-min-100 hidden fixed top-0 left-0 w-full h-screen bg-indigo-800 z-60">
            <!-- Close Header Modal -->
            <div class="absolute top-5 right-5 text-white">
                <i class="fas fa-times text-2xl cursor-pointer" @click="closeMenu"></i>
            </div>

            <!-- Links -->
            <div class="flex justify-center items-center flex-col list-none w-full h-screen text-indigo-800">
                <a class="my-5 py-2 px-5 bg-white rounded w-2/5" href="http://192.168.1.114:8000/admin">Admin Centre <i class="fas fa-user-shield"></i></a>
                <li @click="logUserOut" class="my-5 py-2 px-5 bg-red-500 text-white rounded w-2/5 cursor-pointer">Logout <i class="fas fa-sign-out-alt mt-1.5 ml-1"></i></li>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    methods:{
        ...mapActions('account', ['logTheUserOut']),
        //Open menu
        openMenu(){
            tl.to(this.$refs.adminMenu, {display: 'block', marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        //Close menu
        closeMenu(){
            tl.to(this.$refs.adminMenu, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
        },
        //Log the user out
        logUserOut(){
            this.logTheUserOut().then(() => {
                window.location.replace('http://192.168.1.114:8000/login')
            })
        }
    }
}
</script>