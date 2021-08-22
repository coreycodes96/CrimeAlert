<template>
    <div>
        <!-- Create Announcement Button -->
        <button @click="openAnnouncement" class="mt-2 p-2 w-full h-12 bg-white text-indigo-800">Create Announcement <i class="fas fa-plus"></i></button>
        
        <!-- Create Announcement Modal -->
        <div ref="createAnnouncementModal" class="ml-min-100 fixed top-0 left-0 flex justify-center items-center w-full h-screen bg-indigo-800 z-30">
            <!-- Close Announcement Button -->
            <div class="absolute top-5 right-5 text-white">
                <i @click="closeAnnouncement" class="fas fa-times text-2xl cursor-pointer"></i>
            </div>

            <!-- Form -->
            <div>
                <form @submit.prevent="createAnnouncementForm">
                    <!-- Title & Body Container -->
                    <div class="block w-full">
                        <!-- Title -->
                        <div ref="title" class="my-10 w-full">
                            <input class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-24 text-white placeholder-white resize-none" type="text" placeholder="Title" v-model.trim="title">
                            <span class="text-red-500" v-if="errors.title"><i class="fas fa-exclamation-circle"></i> {{errors.title}}</span>
                        </div>

                        <!-- Body -->
                        <div ref="body" class="my-10 w-full">
                            <textarea class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-24 text-white placeholder-white resize-none" type="text" placeholder="Body" v-model.trim="body"></textarea>
                            <span class="text-red-500" v-if="errors.body"><i class="fas fa-exclamation-circle"></i> {{errors.body}}</span>
                        </div>

                        <!-- Button -->
                        <div class="mt-4 sm:mx-4 mx-0 sm:w-96 w-full">
                            <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Create Announcement! <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    data(){
        return{
            title: '',
            body: '',
            errors:{
                title: '',
                body: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('admin', ['getAnnoucements', 'createAnnouncement']),
        //Open Announcements Modal
        openAnnouncement(){
            tl.to(this.$refs.createAnnouncementModal, {display: 'flex', marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        //Close Announcements Modal
        closeAnnouncement(){
            tl.to(this.$refs.createAnnouncementModal, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
            
            //Clear inputs
            this.title = '';
            this.body = '';

            //Clear Errors
            this.errors.title = '';
            this.errors.body = '';
        },
        createAnnouncementForm(){
            //Title validation
            if(this.titleInput(this.title) === false){
                this.scrollToElement(this.$refs.title);
                this.titleInput(this.title);
            }else{
                this.errors.title = '';
            }

            //Body validation
            if(this.bodyInput(this.body) === false){
                if(this.errors.title === ''){
                    this.scrollToElement(this.$refs.body);
                }
                this.bodyInput(this.body);
            }else{
                this.errors.body = '';
            }

            //Check if validations have passed
            if(this.titleInput(this.title) === true && this.bodyInput(this.body) === true){
                //Letting the user know a request is happening 
                this.loading = true;
                
                //Data
                const data = {
                    'title': this.title,
                    'body': this.body
                };

                this.createAnnouncement(data)
                .then(() => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear inputs
                    this.title = '';
                    this.body = '';

                    //Clear errors
                    this.errors.title = '';
                    this.errors.body = '';
                    
                    //Close Announcements Modal
                    tl.to(this.$refs.createAnnouncementModal, {display: 'none', marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
                })
                .catch(error => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Title errors
                    if(error.response.data.errors.title){
                        this.errors.title = error.response.data.errors.title[0];
                    }

                    //Body errors
                    if(error.response.data.errors.body){
                        this.errors.body = error.response.data.errors.body[0];
                    }
                });
            }
        },
        titleInput(title){
            //Checking if the title is empty
            if(title === ''){
                this.errors.title = 'Please enter a title';
                return false;
            //Checking if the character length is over 150 characters
            }else if(title.length > 150){
                this.errors.title = 'The title limit is 150 characters';
                return false;
            }else{
                return true;
            }
        },
        bodyInput(body){
            //Checking if the body is empty
            if(body === ''){
                this.errors.body = 'Please enter a body';
                return false;
            //Checking if the body is over 5000 characters
            }else if(body.length > 5000){
                this.errors.body = 'The body limit is 5000 characters';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error box is needed
        scrollToElement(el){
            tl.to(this.$refs.createAnnouncementModal, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>