<template>
    <!-- Login container -->
    <div class="sm:mt-24 mt-10 p-5 mx-auto sm:w-4/5 w-full bg-indigo-800 sm:rounded rounded-none select-none">
        <!-- Title -->
        <h2 class="sm:ml-4 ml-0 sm:text-left text-center text-3xl text-white">Login...</h2>

        <!-- Login form -->
        <form @submit.prevent="loginForm" class="mt-10">
            <!-- Email and password container -->
            <div class="sm:flex block w-full">
                <!-- Email -->
                <div ref="email" class="sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="text" placeholder="Email" v-model.trim="email">
                    <span class="text-red-500" v-if="errors.email"><i class="fas fa-exclamation-circle"></i> {{errors.email}}</span>
                </div>
                <!-- Password -->
                <div ref="pword" class="sm:mt-0 mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="password" placeholder="Password" v-model.trim="password">
                    <span class="text-red-500" v-if="errors.password"><i class="fas fa-exclamation-circle"></i> {{errors.password}}</span>
                </div>
            </div>

            <!-- Button -->
            <div class="sm:flex block w-full">
                <div class="mt-4 sm:mx-4 mx-0 sm:w-64 w-full">
                    <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Login <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
    data(){
        return{
            email: '',
            password: '',
            errors:{
                email: '',
                password: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('account', ['logTheUserIn']),
        //Login form
        loginForm(){
            //Regex
            const validEmailOnly = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            //Email validation
            if(this.emailInput(this.email, validEmailOnly) === false){
                this.scrollToElement(this.$refs.email);
                this.emailInput(this.email, validEmailOnly);
            }else{
                this.errors.email = '';
            }

            //Password validation
            if(this.passwordInput(this.password) === false){
                if(this.errors.email === ''){
                    this.scrollToElement(this.$refs.pword);
                }
                this.passwordInput(this.password);
            }else{
                this.errors.password = '';
            }

            //Checking if all the validations have passed
            if(this.emailInput(this.email, validEmailOnly) === true && this.passwordInput(this.password) === true){
                //Letting the user know a request is happening
                this.loading = true;

                //All the input data
                const data = {
                    'email': this.email,
                    'password': this.password
                };

                this.logTheUserIn(data)
                .then(res => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear inputs
                    this.email = '';
                    this.password = '';

                    //Clear errors
                    this.errors.email = '';
                    this.errors.password = '';

                    //Login a user
                    if(res.data.admin === 0){
                        location.replace('http://192.168.1.114:8000/announcements');
                    }

                    //Login an admin
                    if(res.data.admin === 1){
                        location.replace('http://192.168.1.114:8000/admin');
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear password if there is an error
                    this.password = '';
                    
                    //If the information send to the server is incorrect
                    if(error.response.data === 'Incorrect Data'){
                        this.errors.email = 'Please check your email.';
                        this.errors.password = 'Please check your password.';
                    }else{
                        //Email Error
                        if(error.response.data.errors.email){
                            this.errors.email = error.response.data.errors.email[0];
                        }

                        //Password Error
                        if(error.response.data.errors.password){
                            this.errors.password = error.response.data.errors.password[0];
                        }
                    }
                })
            }
        },
        emailInput(email, emailRegex){
            //Checking if the email is empty
            if(email === ''){
                this.errors.email = 'Please enter your email.';
                return false;
            //Checking if the email is larger than 255
            }else if(email.length > 255){
                this.errors.email = 'Your email can\'t be more than 255 characters.';
                return false;
            //Checking if there are 64 more letters after the @ symbol
            }else if(email.split("@")[0].length >= 64){
                this.errors.email = `The email (${email}) is invalid.`;
                return false;
            //Checking if the email is valid
            }else if(!emailRegex.test(email)){
                this.errors.email = `The email (${email}) is invalid.`;
                return false; 
            }else{
                return true;
            }
        },
        passwordInput(password){
            //Checking if the password is empty
            if(password === ''){
                this.errors.password = 'Please enter a password.';
                return false;
            //Checking if the password is less than 8
            }else if(password.length < 8){
                this.errors.password = 'Your password needs to be larger than 8.';
                return false;
            //Checking if the password is larger than 255
            }else if(password.length > 255){
                this.errors.password = 'Your password is too large.';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error in question
        scrollToElement(el){
            tl.to(window, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>