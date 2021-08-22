<template>
    <div ref="changePasswordContainer" class="flex justify-center items-center w-full h-500">
        <!-- Change Password Form -->
        <form @submit.prevent="changeUsersPassword">
            <div class="mx-auto block w-full">
                <!-- Current Password -->
                <div ref="currentPassword" class="mt-10 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-12 text-white placeholder-white" type="password" placeholder="Current Password" v-model.trim="current_password">
                    <span class="text-red-500" v-if="errors.current_password"><i class="fas fa-exclamation-circle"></i> {{errors.current_password}}</span>
                </div>

                <!-- New Password -->
                <div ref="newPassword" class="mt-10 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-12 text-white placeholder-white" type="password" placeholder="New Password" v-model.trim="new_password">
                    <span class="text-red-500" v-if="errors.new_password"><i class="fas fa-exclamation-circle"></i> {{errors.new_password}}</span>
                </div>

                <!-- Confirm New Password -->
                <div ref="confirmNewPassword" class="mt-10 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-12 text-white placeholder-white" type="password" placeholder="Confirm New Password" v-model.trim="confirm_new_password">
                    <span class="text-red-500" v-if="errors.confirm_new_password"><i class="fas fa-exclamation-circle"></i> {{errors.confirm_new_password}}</span>
                </div>

                <!-- Button -->
                <div class="mt-2 sm:mx-4 mx-0 sm:w-96 w-full">
                    <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Change Password! <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
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
        loggedInUserId: Number,
        loggedInUserFirstname: String,
        loggedInUserSurname: String,
        loggedInUserUsername: String
    },
    data(){
        return{
            current_password: '',
            new_password: '',
            confirm_new_password: '',
            errors:{
                current_password: '',
                new_password: '',
                confirm_new_password: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('profile', ['changePassword']),
        changeUsersPassword(){
            //Current password validation
            if(this.currentPasswordInput(this.current_password) === false){
                this.scrollToElement(this.$refs.currentPassword);
                this.currentPasswordInput(this.current_password);
            }else{
                this.errors.current_password = '';
            }

            //Current password validation
            if(this.newPasswordInput(this.new_password) === false){
                if(this.errors.current_password === ''){
                    this.scrollToElement(this.$refs.newPassword);
                }
                this.newPasswordInput(this.new_password);
            }else{
                this.errors.new_password = '';
            }

            //Confirm new password validation
            if(this.confirmNewPasswordInput(this.confirm_new_password, this.new_password) === false){
                if(this.errors.current_password === '' && this.errors.new_password === ''){
                    this.scrollToElement(this.$refs.confirmNewPassword);
                }
                this.confirmNewPasswordInput(this.confirm_new_password, this.new_password);
            }else{
                this.errors.confirm_new_password = '';
            }

            //If the validation passes
            if(this.currentPasswordInput(this.current_password) === true && this.newPasswordInput(this.new_password) === true && this.confirmNewPasswordInput(this.confirm_new_password, this.new_password) === true){
                //Data
                const data = {
                    'user_id': this.loggedInUserId,
                    'current_password': this.current_password,
                    'new_password': this.new_password
                };

                //Letting the user know a request is happening
                this.loading = true;

                this.changePassword(data).then(() => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear the inputs
                    this.current_password = '';
                    this.new_password = '';
                    this.confirm_new_password = '';

                    //Clear the errors
                    this.errors.current_password = '';
                    this.errors.new_password = '';
                    this.errors.confirm_new_password = '';

                    //Redirect the user back to the login page
                    window.location.replace('http://192.168.1.114:8000/login');
                })
                .catch(error => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear the inputs
                    this.current_password = '';
                    this.new_password = '';
                    this.confirm_new_password = '';

                    //UserId error
                    if(error.response.data.errors.user_id){
                        bus.$emit('profile_error');
                    }

                    //Current password error
                    if(error.response.data.errors.current_password){
                        this.errors.current_password = error.response.data.errors.current_password[0];
                    }

                    //New password error
                    if(error.response.data.errors.new_password){
                        this.errors.new_password = error.response.data.errors.new_password[0];
                    }
                });
            }
        },
        currentPasswordInput(current_password){
            //Checking if the current password is empty
            if(current_password === ''){
                this.errors.current_password = 'Please enter your current password';
                return false;
            //Checking if the current password length is less than 8 characters
            }else if(current_password.length < 8){
                this.errors.current_password = 'Your password can\'t be less than 8 characters';
                return false;
            //Checking if the current password length is more than 255 characters
            }else if(current_password.length > 255){
                this.errors.current_password = 'Your password can\'t be more than 255 characters';
                return false;
            }else{
                return true;
            }
        },
        newPasswordInput(new_password){
            //Checking if the new password is empty
            if(new_password === ''){
                this.errors.new_password = 'Please enter your new password';
                return false;
            //Checking if the new password length is more less than 8 characters
            }else if(new_password.length < 8){
                this.errors.new_password = 'Your password can\'t be less than 8 characters';
                return false;
            //Checking if the new password length is more than 255 characters
            }else if(new_password.length > 255){
                this.errors.new_password = 'Your password can\'t be more than 255 characters';
                return false;
            //Checking if the new password doesn't include the users firstname, surname or username
            }else if(new_password.toLowerCase().indexOf(this.loggedInUserFirstname.toLowerCase()) > -1 || new_password.toLowerCase().indexOf(this.loggedInUserSurname.toLowerCase()) > -1 || new_password.toLowerCase().indexOf(this.loggedInUserUsername.toLowerCase()) > -1){
                this.errors.new_password = 'Your password can\'t contain your firstname, surname and username.';
                return false;
            }else{
                return true;
            }
        },
        confirmNewPasswordInput(confirm_new_password, new_password){
            //Checking if the confirm new password is empty
            if(confirm_new_password === ''){
                this.errors.confirm_new_password = 'Please confirm your password';
                return false;
            //Checking if the confirm new password is equal to the new password
            }else if(confirm_new_password !== new_password){
                this.errors.confirm_new_password = 'Sorry password does not match';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error box is needed
        scrollToElement(el){
            tl.to(this.$refs.changePasswordContainer, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>