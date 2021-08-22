<template>
    <div class="sm:mt-0 mt-2">
        <input @keyup="searching" class="pl-1 w-56 text-black" type="text" placeholder="search for users..." v-model="search">
        <div v-if="typing" class="p-3 absolute w-56 h-56 bg-indigo-800 overflow-y-scroll border-2 border-white">
            <!-- Loader -->
            <div v-if="loading" class="absolute top-0 left-0 flex justify-center items-center bg-indigo-800 w-full h-full z-50">
                <div class="p-3 text-white">
                    <i class="fas fa-spinner animate-spin text-xl"></i>
                </div>
            </div>

            <!-- No Search Results -->
            <div v-if="fetchSearch.length === 0" class="flex justify-center items-center w-full h-full">No Results</div>

            <!-- Displaying The Search Results -->
            <div v-for="search in fetchSearch" :key="search.id">
                <a :href="'http://192.168.1.114:8000/profile/'+search.username">
                    <div class="my-5 p-3 bg-white text-indigo-800">
                        <p class="text-sm">{{search.username}}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
    data(){
        return{
            typing: false,
            search: '',
            loading: false
        }
    },
    methods:{
        ...mapActions('search', ['makingASearch']),
        //Making a request to get the search results
        searching(){
            if(this.search === '') return this.typing = false;
            this.typing = true;
            this.loading = true;

            const data = {
                'data': this.search
            };

            this.makingASearch(data).then(() => {
                this.loading = false;
            });
        },
    },
    computed:{
        ...mapGetters('search', ['fetchSearch'])
    }
}
</script>