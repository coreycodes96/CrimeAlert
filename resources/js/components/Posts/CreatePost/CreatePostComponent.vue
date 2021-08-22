<template>
    <div>
        <!-- Create a post button -->
        <div class="fixed bottom-0 right-0 flex justify-end items-center w-full h-16 z-30 pointer-events-none">
            <div class="mb-20 mr-5 p-1 bg-white rounded-full">
                <i @click="openPostModal" class="fas fa-plus-circle text-indigo-800 border-4 border-black rounded-full text-6xl cursor-pointer pointer-events-auto"></i>
            </div>
        </div>

        <!-- Create a post form -->
        <div ref="postModal" class="ml-min-100 fixed top-0 left-0 flex justify-center items-center flex-col w-full h-screen bg-indigo-800 z-50">
            <!-- Close Form -->
            <div class="absolute top-5 right-5 text-white">
                <i @click="closePostModal" class="fas fa-times text-2xl cursor-pointer"></i>
            </div>

            <!-- Create A Post Form -->
            <div>
                <form @submit.prevent="createAPost" enctype="multipart/form-data">
                    <div class="block w-full">
                        <!-- Body -->
                        <div ref="body" class="my-10 w-full">
                            <textarea class="mb-2 pl-1 bg-transparent outline-none border-b-4 border-white w-full h-24 text-white placeholder-white resize-none" type="text" placeholder="Caption" v-model.trim="body"></textarea>
                            <span class="text-red-500" v-if="errors.body"><i class="fas fa-exclamation-circle"></i> {{errors.body}}</span>
                        </div>

                        <!-- Location -->
                        <div ref="location" class="my-10 w-full">
                            <select class="mb-2 pl-1 bg-indigo-800 text-white outline-none border-b-4 border-white w-full h-8 text-white placeholder-white" placeholder="Location" v-model.trim="location">
                                <option disabled selected value="">Location</option>
                                <option value="Bath">Bath</option>
                                <option value="Birmingham">Birmingham</option>
                                <option value="Bradford">Bradford</option>
                                <option value="Brighton and Hove">Brighton and Hove</option>
                                <option value="Bristol">Bristol</option>
                                <option value="Brighton and Hove">Brighton and Hove</option>
                                <option value="Cambridge">Cambridge</option>
                                <option value="Canterbury">Canterbury</option>
                                <option value="Carlisle">Carlisle</option>
                                <option value="Chester">Chester</option>
                                <option value="Chelmsford">Chelmsford</option>
                                <option value="Chichester">Chichester</option>
                                <option value="Coventry">Coventry</option>
                                <option value="Derby">Derby</option>
                                <option value="Durham">Durham</option>
                                <option value="Ely">Ely</option>
                                <option value="Exeter">Exeter</option>
                                <option value="Gloucester">Gloucester</option>
                                <option value="Hereford">Hereford</option>
                                <option value="Kingston upon Hull">Kingston upon Hull</option> 
                                <option value="Lancaster">Lancaster</option>
                                <option value="Leeds">Leeds</option>
                                <option value="Leicester">Leicester</option>
                                <option value="Lichfield">Lichfield</option>
                                <option value="Lincoln">Lincoln</option>
                                <option value="Liverpool">Liverpool</option>
                                <option value="London">London</option>
                                <option value="Manchester">Manchester</option>
                                <option value="Newcastle upon Tyne">Newcastle upon Tyne</option>
                                <option value="Norwich">Norwich</option>
                                <option value="Nottingham">Nottingham</option>
                                <option value="Oxford">Oxford</option>
                                <option value="Peterborough">Peterborough</option>
                                <option value="Plymouth">Plymouth</option>
                                <option value="Portsmouth">Portsmouth</option>
                                <option value="Preston">Preston</option>
                                <option value="Ripon">Ripon</option>
                                <option value="Salford">Salford</option>
                                <option value="Salisbury">Salisbury</option>
                                <option value="Sheffield">Sheffield</option>
                                <option value="Southampton">Southampton</option>
                                <option value="St Albans">St Albans</option>
                                <option value="Stoke-on-Trent">Stoke-on-Trent</option>
                                <option value="Sunderland">Sunderland</option>
                                <option value="Truro">Truro</option>
                                <option value="Wakefield">Wakefield</option>
                                <option value="Wells">Wells</option>
                                <option value="Westminster">Westminster</option>
                                <option value="Winchester">Winchester</option>
                                <option value="Wolverhampton">Wolverhampton</option>
                                <option value="Worcester">Worcester</option>
                                <option value="York">York</option>
                            </select>
                            <span class="text-red-500" v-if="errors.location"><i class="fas fa-exclamation-circle"></i> {{errors.location}}</span>
                        </div>

                        <!-- Media -->
                        <div ref="media" class="w-full">
                            <input @change="mediaChange($event)" class="w-full" type="file" ref="file" placeholder="Media">
                            <span class="text-red-500" v-if="errors.media"><i class="fas fa-exclamation-circle"></i> {{errors.media}}</span>
                        </div>
                        
                        <!-- Button -->
                        <div class="mt-4 sm:mx-4 mx-0 sm:w-96 w-full">
                            <button :disabled="loading" class="mt-4 p-2 bg-white text-indigo-800 w-full rounded focus:outline-none" type="submit">Create Post! <i v-if="loading" class="ml-2 fas fa-spinner animate-spin"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        'loggedInUserId': Number
    },
    data(){
        return{
            body: '',
            location: '',
            media: null,
            status: 0,
            errors: {
                body: '',
                location: '',
                media: ''
            },
            loading: false
        }
    },
    methods:{
        ...mapActions('posts', ['getPosts', 'createPost']),
        //Close Posts
        openPostModal(){
            tl.to(this.$refs.postModal, {marginLeft: '0', duration: 0.3, ease: "power3.out"});
        },
        //Close Posts
        closePostModal(){
            tl.to(this.$refs.postModal, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});

            //Clear inputs
            this.body = '';
            this.location = '';

            //Clear errors
            this.errors.body = '';
            this.errors.location = '';
            this.errors.media = null;
        },
        //Add file
        mediaChange(event){
            this.media = event.target.files[0];
        },
        createAPost(){
            //Body validation
            if(this.bodyInput(this.body) === false){
                this.scrollToElement(this.$refs.body);
                this.bodyInput(this.body);
            }else{
                this.errors.body = '';
            }

            //Location validation
            if(this.locationInput(this.location) === false){
                if(this.errors.body === ''){
                    this.scrollToElement(this.$refs.location);
                }

                this.locationInput(this.location);
            }else{
                this.errors.location = '';
            }

            //Media validation
            if(this.mediaInput(this.media) === false){
                if(this.errors.body === '' && this.errors.location === ''){
                    this.scrollToElement(this.$refs.media);
                }
                this.mediaInput(this.media);
            }else{
                this.errors.media = '';
            }

            //Checking if all the validations have passed
            if(this.bodyInput(this.body) === true && this.mediaInput(this.media) === true){
                //Letting the user know a request is happening
                this.loading = true;

                //Form Data
                let data = new FormData();
                data.append('user_id', this.loggedInUserId);
                data.append('body', this.body);
                data.append('location', this.location);
                data.append('media', this.media);
                data.append('status', this.status);

                this.createPost(data)
                .then(() => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //Clear inputs
                    this.body = '';
                    this.location = '';

                    //Clear errors
                    this.errors.body = '';
                    this.errors.location = '';
                    this.errors.media = null;
                    
                    //Getting the posts
                    this.getPosts(1);

                    //Close Posts
                    tl.to(this.$refs.postModal, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});

                    bus.$emit('post_success');
                })
                .catch(error => {
                    //Letting the user the request has a response
                    this.loading = false;

                    //UserId error
                    if(error.response.data.errors.user_id){
                        //Clear inputs
                        this.body = '';
                        this.location = '';

                        //Clear errors
                        this.errors.body = '';
                        this.errors.location = '';
                        this.errors.media = null;

                        //Close posts
                        tl.to(this.$refs.postModal, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});

                        //Add an error message
                        bus.$emit('post_error');
                    }

                    //Body Error
                    if(error.response.data.errors.body){
                        this.errors.body = error.response.data.errors.body[0];
                    }

                    //Location Error
                    if(error.response.data.errors.location){
                        this.errors.location = error.response.data.errors.location[0];
                    }

                    //Media Error
                    if(error.response.data.errors.media){
                        this.errors.media = error.response.data.errors.media[0];
                    }
                });
            }
        },
        bodyInput(body){
            //Checking if body is empty
            if(body === ''){
                this.errors.body = 'Please enter your caption for your post';
                return false;
            //Checking if the body length is over 1000 characters
            }else if(body.length > 1000){
                this.errors.body = 'Caption can only been 1000 characters';
                return false;
            }else{
                return true;
            }
        },
        locationInput(location){
            //Checking if the location is empty
            if(location === ''){
                this.errors.location = 'Please enter your location';
                return false;
            //Checking if the location length is over 30 characters
            }else if(location.length > 30){
                this.errors.location = 'Location can only have 30 characters';
                return false;   
            }else{
                return true;
            }
        },
        mediaInput(media){
            //file extentions
            const ext = ['png', 'jpeg', 'jpg', 'mp4', 'webm'];
            
            //Checking if the media is empty
            if(media === null){
                this.errors.media = 'Please select a file';
                return false;
            //Checking if the media file has the correct file extention
            }else if(ext.includes(media.type.split('/')[1]) === false){
                this.errors.media = 'You have selected the wrong file type.';
                return false;
            //Checking if the media file has the correct file size
            }else if(media.size > 2097152){
                this.errors.media = 'File size is too large.';
                return false;
            }else{
                return true;
            }
        },
        //GSAP animation to scroll to the error box is needed
        scrollToElement(el){
            tl.to(this.$refs.postModal, {duration: 0.5, scrollTo: {y: el, offsetY: 150}});
        },
    }
}
</script>