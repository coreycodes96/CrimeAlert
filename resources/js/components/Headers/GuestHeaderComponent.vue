<template>
    <div>
        <!-- Header -->
        <div class="fixed top-0 left-0 flex justify-around items-center w-full h-12 bg-indigo-800 border-b-4 border-white text-white select-none">
            <!-- Title -->
            <h1 class="text-xl">CrimeAlert</h1>

            <!-- Menu Icon -->
            <div class="flex list-none">
                <li class="flex" @click="openMenu"><i class="fas fa-bars text-xl cursor-pointer"></i></li>
            </div>
        </div>
        <div class="w-full h-12"></div>

        <!-- Header Modal -->
        <div ref="guestMenu" class="ml-min-100 hidden fixed top-0 left-0 w-full h-screen bg-indigo-800 z-60">
            <!-- Close Header Modal -->
            <div class="absolute top-5 right-5 text-white">
                <i class="fas fa-times text-2xl cursor-pointer" @click="closeMenu"></i>
            </div>

            <!-- Links -->
            <div class="flex justify-center items-center flex-col list-none w-full h-screen text-indigo-800">
                <a class="my-5 py-2 px-5 bg-white rounded w-2/5" href="/">Home <i class="fas fa-home"></i></a>
                <a class="my-5 py-2 px-5 bg-white rounded w-2/5" href="/register">Create An Account <i class="fas fa-user-plus"></i></a>
                <a class="my-5 py-2 px-5 bg-white rounded w-2/5" href="/login">Login <i class="fas fa-sign-in-alt"></i></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods:{
        //Open menu
        openMenu(){
            tl.to(this.$refs.guestMenu, {display: 'block', marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        //Close menu
        closeMenu(){
            tl.to(this.$refs.guestMenu, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
        }
    }
}
</script>