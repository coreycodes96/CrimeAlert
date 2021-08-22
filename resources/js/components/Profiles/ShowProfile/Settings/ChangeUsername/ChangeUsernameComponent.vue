<template>
    <div ref="changeUsernameContainer" class="flex justify-center items-center w-full h-500">
        <!-- Change Username Form -->
        <form @submit.prevent="changeUsersUsername">
            <div class="mx-auto block w-full">
                <!-- Username -->
                <div ref="username" class="mt-10 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-12 text-white placeholder-white" type="text" placeholder="Username" v-model.trim="username">
                    <span class="text-red-500" v-if="errors.username"><i class="fas fa-exclamation-circle"></i> {{errors.username}}</span>
                </div>

                <!-- Button -->
                <div class="mt-2 sm:mx-4 mx-0 sm:w-96 w-full">
                    <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Change Username! <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../../app';
export default {
    props:{
        loggedInUserId: Number
    },
    data(){
        return{
            username: '',
            errors:{
                username: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('profile', ['changeUsername']),
        changeUsersUsername(){
            //Username validation
            if(this.usernameInput(this.username) === false){
                this.scrollToElement(this.$refs.username);
                this.usernameInput(this.username);
            }else{
                this.errors.username = '';
            }

            //If the validation passes
            if(this.usernameInput(this.username) === true){
                //Data
                const data = {
                    'user_id': this.loggedInUserId,
                    'username': this.username
                };
                
                //Letting the user know a request is happening
                this.loading = true;

                this.changeUsername(data)
                .then(() => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Redirecting the user
                    window.location.replace(`http://192.168.1.114:8000/profile/${this.username}`);
                }).catch(error => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //UserId error
                    if(error.response.data.errors.user_id){
                        bus.$emit('profile_error');
                    }

                    //Username error
                    if(error.response.data.errors.username === 'Username has already been taken'){
                        this.errors.username = 'Username has already been taken';
                    }else{
                        this.errors.username = error.response.data.errors.username[0];
                    }
                });
            }
        },
        usernameInput(username){
            //Checking if the username is empty
            if(username === ''){
                this.errors.username = 'Please enter your username';
                return false;
            //Checking if the username length is over 25 characters
            }else if(username.length > 25){
                this.errors.username = 'Your username is too long. Minimum of 25 characters.';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error box is needed
        scrollToElement(el){
            tl.to(this.$refs.changeUsernameContainer, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>