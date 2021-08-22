<template>
    <!-- Create an account container -->
    <div class="sm:mt-24 mt-10 p-5 mx-auto sm:w-4/5 w-full bg-indigo-800 sm:rounded rounded-none select-none">
        <!-- Title -->
        <h2 class="sm:ml-4 ml-0 sm:text-left text-center text-3xl text-white">Create an account...</h2>
        
        <!-- Create an account form -->
        <form @submit.prevent="createAnAccountForm" class="mt-10">
            <!-- Firstname and surname container -->
            <div class="sm:flex block w-full">
                <!-- Firstname -->
                <div ref="fname" class="sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="text" placeholder="Firstname" v-model.trim="firstname">
                    <span class="text-red-500" v-if="errors.firstname"><i class="fas fa-exclamation-circle"></i> {{errors.firstname}}</span>
                </div>
                <!-- Surname -->
                <div ref="sname" class="sm:mt-0 mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="text" placeholder="Surname" v-model.trim="surname">
                    <span class="text-red-500" v-if="errors.surname"><i class="fas fa-exclamation-circle"></i> {{errors.surname}}</span>
                </div>
            </div>

            <!-- Username and email container -->
            <div class="sm:flex block w-full">
                <!-- Username -->
                <div ref="uname" class="mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="text" placeholder="Username" v-model.trim="username">
                    <span class="text-red-500" v-if="errors.username"><i class="fas fa-exclamation-circle"></i> {{errors.username}}</span>
                </div>
                <!-- Email -->
                <div ref="email" class="mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="text" placeholder="Email" v-model.trim="email">
                    <span class="text-red-500" v-if="errors.email"><i class="fas fa-exclamation-circle"></i> {{errors.email}}</span>
                </div>
            </div>

            <!-- Date of birth and password container -->
            <div class="sm:flex block w-full">
                <!-- DOB -->
                <div ref="dob" class="mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="date" min="1920-01-01" max="2005-01-01" placeholder="Date Of Birth" v-model.trim="dob">
                    <span class="text-red-500" v-if="errors.dob"><i class="fas fa-exclamation-circle"></i> {{errors.dob}}</span>
                </div>
                <!-- Password -->
                <div ref="pword" class="mt-4 sm:mx-4 mx-0 sm:w-3/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="password" placeholder="Password" v-model.trim="password">
                    <span class="text-red-500" v-if="errors.password"><i class="fas fa-exclamation-circle"></i> {{errors.password}}</span>
                </div>
            </div>

            <!-- Confirm password container -->
            <div class="sm:flex block w-full">
                <!-- Confirm Password -->
                <div ref="confirm_pword" class="mt-4 sm:mx-4 mx-0 sm:w-6/6 w-full">
                    <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" type="password" placeholder="Confirm Password" v-model.trim="confirm_password">
                    <span class="text-red-500" v-if="errors.confirm_password"><i class="fas fa-exclamation-circle"></i> {{errors.confirm_password}}</span>
                </div>
            </div>

            <!-- Button -->
            <div class="sm:flex block w-full">
                <div class="mt-4 sm:mx-4 mx-0 sm:w-96 w-full">
                    <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Create Account! <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
                </div>
            </div>

            <!-- Agree to terms and conditions -->
            <input class="mt-3 sm:ml-4 ml-0" type="checkbox" v-model="check" @click="check = !check"> <span class="text-sm text-white cursor-pointer" @click="openTermsAndConditions">Agree to terms and conditions</span>
            <div class="mt-2 sm:ml-4 ml-0 text-red-500" v-if="errors.check"><i class="fas fa-exclamation-circle"></i> {{errors.check}}</div>
            <TermsAndConditions></TermsAndConditions>
        </form>

        <!-- Success Message -->
        <div ref="accountSuccess" class="mb-min-100 fixed bottom-0 left-0 p-3 w-full h-12 bg-green-600 text-center text-white">Congratulations! You have successfully created an account!! (<a href="http://192.168.1.114:8000/login">Login here!</a>)</div>
    </div>
</template>

<script>
import TermsAndConditions from './TermsAndConditionsComponent';
import {mapActions} from 'vuex';
export default{
    components:{
        TermsAndConditions
    },
    data(){
        return{
            firstname: '',
            surname: '',
            username: '',
            email: '',
            dob: '',
            password: '',
            confirm_password: '',
            check: false,
            success: '',
            errors: {
                firstname: '',
                surname: '',
                username: '',
                email: '',
                dob: '',
                password: '',
                confirm_password: '',
                check: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('account', ['createAnAccount']),
        //Success message
        successMessage(){
            tl.to(this.$refs.accountSuccess, 1, {marginBottom: 0, ease: Elastic.easeOut.config(1, 1)});
        },
        //Open terms and conditions
        openTermsAndConditions(){
            tl.to('.termsAndConditions', {marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        //Create an account
        createAnAccountForm(){
            //Regex
            const textNumbersOnly = /^[a-zA-Z0-9]+$/i;
            const validEmailOnly = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            //Firstname validation
            if(this.firstnameInput(this.firstname) === false){
                this.scrollToElement(this.$refs.fname);
                this.firstnameInput(this.firstname);
            }else{
                this.errors.firstname = '';
            }

            //Surname validation
            if(this.surnameInput(this.surname) === false){
                if(this.errors.firstname === ''){
                    this.scrollToElement(this.$refs.sname);
                }
                this.surnameInput(this.surname);
            }else{
                this.errors.surname = '';
            }

            //Username validation
            if(this.usernameInput(this.username, textNumbersOnly) === false){
                if(this.errors.firstname === '' && this.errors.surname === ''){
                    this.scrollToElement(this.$refs.uname);
                }
                this.usernameInput(this.username, textNumbersOnly);
            }else{
                this.errors.username = '';
            }

            //Email validation
            if(this.emailInput(this.email, validEmailOnly) === false){
                if(this.errors.firstname === '' && this.errors.surname === '' && this.errors.username === ''){
                    this.scrollToElement(this.$refs.email);
                }
                this.emailInput(this.email, validEmailOnly);
            }else{
                this.errors.email = '';
            }

            //DOB validation
            if(this.dobInput(this.dob) === false){
                if(this.errors.firstname === '' && this.errors.surname === '' && this.errors.username === '' && this.errors.email === ''){
                    this.scrollToElement(this.$refs.dob);
                }
                this.dobInput(this.dob);
            }else{
                this.errors.dob = '';
            }

            //Password validation
            if(this.passwordInput(this.password, this.firstname, this.surname, this.username) === false){
                if(this.errors.firstname === '' && this.errors.surname === '' && this.errors.username === '' && this.errors.email === '' && this.errors.dob === ''){
                    this.scrollToElement(this.$refs.pword);
                }
                this.passwordInput(this.password, this.firstname, this.surname, this.username);
            }else{
                this.errors.password = '';
            }

            //Confirm password validation
            if(this.confirmPasswordInput(this.confirm_password, this.password) === false){
                if(this.errors.firstname === '' && this.errors.surname === '' && this.errors.username === '' && this.errors.email === '' && this.errors.dob === '' && this.errors.password === ''){
                    this.scrollToElement(this.$refs.confirm_pword);
                }
                this.confirmPasswordInput(this.confirm_password, this.password);
            }else{
                this.errors.confirm_password = '';
            }

            //Checkbox validation
            if(this.check === false){
                this.errors.check = 'Please agree to the terms and conditions.';
            }else{
                this.errors.check = '';
            }

            //Checking if all the validations have passed
            if(this.firstnameInput(this.firstname) === true && this.surnameInput(this.surname) === true && this.usernameInput(this.username, textNumbersOnly) === true && this.emailInput(this.email, validEmailOnly) === true && this.dobInput(this.dob) === true && this.passwordInput(this.password, this.firstname, this.surname, this.username) === true && this.confirmPasswordInput(this.confirm_password, this.password) === true && this.check === true){
                //Letting the user know a request is happening
                this.loading = true;

                //All the input data
                const data = {
                    'firstname': this.firstname,
                    'surname': this.surname,
                    'username': this.username,
                    'email': this.email,
                    'dob': this.dob,
                    'admin': 0,
                    'password': this.password,
                    'password_confirmation': this.confirm_password
                };
                
                //Sending a request to the server
                this.createAnAccount(data)
                .then(() => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Displaying the success message
                    tl.to(this.$refs.accountSuccess, 1, {marginBottom: 0, ease: Elastic.easeOut.config(1, 1)});
                    
                    //Clearing the inputs
                    this.firstname = '';
                    this.surname = '';
                    this.username = '';
                    this.email = '';
                    this.dob = '';
                    this.password = '';
                    this.confirm_password = '';

                    //Clearing the errors
                    this.errors.firstname = '';
                    this.errors.surname = '';
                    this.errors.username = '';
                    this.errors.email = '';
                    this.errors.dob = '';
                    this.errors.password = '';
                    this.errors.confirm_password = '';
                })
                .catch(e => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clearing password inputs
                    this.password = '';
                    this.confirm_password = '';

                    //Hiding the success message
                    tl.to(this.$refs.accountSuccess, 1, {marginBottom: '-100%', ease: Elastic.easeOut.config(1, 1)});
                    
                    //Firstname errors
                    if(e.response.data.errors.firstname){
                        this.errors.firstname = e.response.data.errors.firstname[0];
                    }

                    //Surname errors
                    if(e.response.data.errors.surname){
                        this.errors.surname = e.response.data.errors.surname[0];
                    }

                    //Username errors
                    if(e.response.data.errors.username){
                        this.errors.username = e.response.data.errors.username[0];
                    }

                    //Email errors
                    if(e.response.data.errors.email){
                        this.errors.email = e.response.data.errors.email[0];
                    }
                    
                    //DOB errors
                    if(e.response.data.errors.dob){
                        this.errors.dob = e.response.data.errors.dob[0];
                    }

                    //Password errors
                    if(e.response.data.errors.password){
                        this.errors.password = e.response.data.errors.password[0];
                    }

                    //Confirm password errors
                    if(e.response.data.errors.password_confirmation){
                        this.errors.confirm_password = e.response.data.errors.password_confirmation[0];
                    }

                    //Password does not match error for confirm_password
                    if(e.response.data.errors.password[0] === 'The password confirmation does not match.'){
                        this.errors.confirm_password = e.response.data.errors.password[0];
                    }
                })
            }
        },
        firstnameInput(firstname){
            //Checking if the firstname is empty
            if(firstname === ""){
                this.errors.firstname = 'Please enter your firstname.';
                return false;
            //Checking if the firstname length is larger than 25
            }else if(firstname.length > 25){
                this.errors.firstname = 'Your firstname is too large.';
                return false;
            }else{
                return true;
            }
        },
        surnameInput(surname){
            //Checking if the surname is empty
            if(surname === ""){
                this.errors.surname = 'Please enter your surname.';
                return false;
            //Checking if the surname length is larger than 25
            }else if(surname.length > 25){
                this.errors.surname = 'Your surname is too large.';
                return false;
            }else{
                return true;
            }
        },
        usernameInput(username, textNumbersOnlyRegex){
            //Checking if the username is empty
            if(username === ''){
                this.errors.username = 'Please enter a username.';
                return false;
            //Checking if the username is larger than 25
            }else if(username.length > 25){
                this.errors.username = 'Your username is too large.';
                return false;
            //Checking if the username doesn't contain letters and numbers
            }else if(!textNumbersOnlyRegex.test(username)){
                this.errors.username = 'Your username can only contain letters and numbers.';
                return false;
            }else{
                return true;
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
        dobInput(dob){
            //Checking if the dob is empty
            if(dob === ''){
                this.errors.dob = 'Please enter your date of birth.';
                return false;
            }else{
                return true;
            }
        },
        passwordInput(password, firstname, surname, username){
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
            }else if(password.toLowerCase().indexOf(firstname.toLowerCase()) > -1 || password.toLowerCase().indexOf(surname.toLowerCase()) > -1 || password.toLowerCase().indexOf(username.toLowerCase()) > -1){
                this.errors.password = 'Your password can\'t contain your firstname, surname and username.';
                return false;
            }else{
                return true;
            }
        },
        confirmPasswordInput(confirm_password, password){
            //Checking if confirm password is empty
            if(confirm_password === ''){
                this.errors.confirm_password = 'Please confirm your password.';
                return false;
            }else if(confirm_password !== password){
                this.errors.confirm_password = 'Your passwords do not match.';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error box is needed
        scrollToElement(el){
            tl.to(window, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>

<style scoped>
    /* Changing the calendar picker colour to black */
    ::-webkit-calendar-picker-indicator{
        filter: invert(1);
    }
</style>