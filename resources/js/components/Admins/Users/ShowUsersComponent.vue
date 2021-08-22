<template>
    <div>
        <!-- Loader -->
        <template v-if="loading">
            <div class="p-3 flex justify-center items-center w-full h-350 rounded text-indigo-800">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </template>

        <template v-else>
            <!-- No Users -->
            <div v-if="showUsers.length === 0">
                <div class="flex justify-center items-center w-full h-350 text-indigo-800">
                    <p class="text-xl">No Results :(</p>
                </div>
            </div>

            <!-- User Results -->
            <div v-else v-for="(user) in showUsers" :key="user.id">
                <div class="my-10 mx-auto p-2 w-4/5 h-auto flex justify-between items-center bg-indigo-800 text-white">
                    <p>{{user.username}}</p>

                    <!-- Delete User -->
                    <DeleteUsersAccount :user-id="user.id"/>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import DeleteUsersAccount from './DeleteUsersAccountComponent';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../../app';
export default {
    components:{DeleteUsersAccount},
    props:{
        search: String
    },
    data(){
        return{
            loading: false
        }
    },
    methods:{
        ...mapActions('admin', ['getUsers']),
    },
    computed:{
        ...mapGetters('admin', ['fetchUsers']),
        //Filter the users results with the search input
        showUsers(){
            //Filter through the data and display the matching results
            const show_users = this.fetchUsers.filter(user => {
                return Object.values(user).some(u => u.toString().toLowerCase().startsWith(this.search.toLowerCase()));
            })

            return show_users;
        },
    },
    created(){
        //Letting the user know a request is happening 
        this.loading = true;

        this.getUsers()
        .then(() => {
            //Letting the user the request has a response
            this.loading = false;
        })
        .catch(() => {
            //Letting the user the request has a response
            this.loading = false;

            //Adding an error message
            bus.$emit('admin_error');
        })
    }
}
</script>