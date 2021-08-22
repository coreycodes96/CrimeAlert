<template>
    <div>
        <!-- Loader -->
        <div v-if="loading" class="fixed top-0 left-0 flex justify-center items-center w-full h-screen z-50">
            <div class="p-3 bg-indigo-800 rounded text-white">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </div>

        <!-- Success Message -->
        <SuccessNotification />

        <!-- Error Notifications -->
        <ErrorNotification />

        <!-- Pagination -->
        <div class="my-10 flex justify-around items-center w-full h-12">
            <button @click="prevPage" v-if="!dataHasLoaded && fetchPosts.current_page !== 1"><i class="fas fa-backward text-xl"></i></button>
            <button @click="nextPage" v-if="!dataHasLoaded && fetchPosts.last_page !== fetchPosts.current_page"><i class="fas fa-forward text-xl"></i></button>
        </div>

        <!-- No Crimes Posted -->
        <template v-if="fetchPosts.total == 0">
            <div class="p-5 flex justify-center items-center w-full h-96 text-indigo-800 select-none">
                <p class="text-3xl">No crimes have been alerted as of now...</p>
            </div>
        </template>
        
        <!-- Post -->
        <template v-else>
            <div v-for="(post, postIndex) in fetchPosts.data" :key="post.id">
                <div class="relative p-5 my-10 sm:mx-auto mx-0 bg-indigo-800 sm:w-4/5 w-full text-white sm:rounded rounded-none select-none">
                    <!-- Image/Video -->
                    <div v-html="displayMedia(post.media)"></div>

                    <!-- Information -->
                    <div>
                        <p class="mt-10 whitespace-pre-line">{{post.body}}</p>
                        <p class="mt-5"><i class="fas fa-location-arrow"></i> {{post.location}}</p>
                        <div v-if="post.user" class="mt-5 flex justify-between items-center w-full h-auto">
                            <p class="mr-5"><i class="fas fa-pen"></i> Created By: <a :href="`http://192.168.1.114:8000/profile/${post.user.username}`">{{post.user.username}}</a></p>
                            <p><i class="fas fa-clock"></i> {{timeSince(post.created_at)}} ago</p>
                        </div>
                    </div>

                    <!-- Icons -->
                    <div class="mt-10 flex justify-between items-center w-full h-12">
                        <!-- Like Post -->
                        <LikePost v-if="post.likes" :post-index="postIndex" :post-id="post.id" :post-creator-id="post.userId" :logged-in-user-id="loggedInUserId" :likes="post.likes"/>
                        
                        <!-- Show Comments -->
                        <ShowComments :logged-in-user-id="loggedInUserId" :post-id="post.id" :comment-count="post.comments_count"/>
                        
                        <!-- Delete Post -->
                        <DeletePost v-if="loggedInUserId === post.user_id" :post-index="postIndex" :post-id="post.id"/>
                    </div>
                </div>
            </div>
        </template>

        <!-- Pagination -->
        <div class="my-10 flex justify-around items-center w-full h-12">
            <button @click="prevPage" v-if="!dataHasLoaded && fetchPosts.current_page !== 1"><i class="fas fa-backward text-xl"></i></button>
            <button @click="nextPage" v-if="!dataHasLoaded && fetchPosts.last_page !== fetchPosts.current_page"><i class="fas fa-forward text-xl"></i></button>
        </div>
    </div>
</template>

<script>
import LikePost from '../LikePost/LikePostComponent';
import DeletePost from '../DeletePost/DeletePostComponent';
import ShowComments from '../Comments/ShowComments/ShowCommentsComponent';
import SuccessNotification from '../../PostSuccess/PostSuccessComponent';
import ErrorNotification from '../../Errors/ErrorNotificationComponent';
import formatDistance from 'date-fns/formatDistance';
import {mapGetters, mapActions} from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        loggedInUserId: Number
    },
    components:{LikePost, DeletePost, ShowComments, SuccessNotification, ErrorNotification},
    data(){
        return{
            page: 1,
            loading: false,
            dataHasLoaded: false
        }
    },
    methods:{
        ...mapActions('posts', ['getPosts']),
        prevPage(){
            //Letting the user know a request is happening
            this.loading = true;
            this.getPosts(this.page - 1)
            .then(() => {
                //Letting the user the request has a response
                this.loading = false;
            })
            .catch(() => {
                //Letting the user the request has a response
                this.loading = false;

                //Error message
                bus.$emit('post_error_info', 'There seems to be an error please try again later.');
            });
        },
        nextPage(){
            //Letting the user know a request is happening
            this.loading = true;
            this.getPosts(this.page + 1)
            .then(() => {
                //Letting the user the request has a response
                this.loading = false;
            })
            .catch(() => {
                //Letting the user the request has a response
                this.loading = false;

                //Error message
                bus.$emit('post_error_info', 'There seems to be an error please try again later.');
            });
        },
        //Checking if the user post is a video or an image
        displayMedia(media){
            //file extentions
            const ext = ['png', 'jpeg', 'jpg'];

            if(ext.includes(media.split('.', 2)[1])){
                return `<img class="w-full h-96 bg-white object-contain" src="../storage/${media}" alt="post">`;
            }else{
                return `
                    <video class="relative w-full h-96 bg-white object-contain z-10" controls>
                        <source src="../storage/${media}"/>
                    </video>
                `;
            }
        },
        //Making it easier for the user see the when the post was created
        timeSince(date) {
            return formatDistance(new Date(), new Date(date));
        }
    },
    computed:{
        ...mapGetters('posts', ['fetchPosts'])
    },
    created(){
        //Errors
        bus.$on('post_error', () => {
            bus.$emit('error_info', 'There seems to be an error please try again later.');
        });

        //Success
        bus.$on('post_success', () => {
            bus.$emit('success_info', 'Your post has been successfully created! Please wait for it to be approved');
        });
        
        //Data is being loaded
        this.dataHasLoaded = true;
        this.getPosts(this.page)
        .then(() => {
            //Data has been loaded
            this.dataHasLoaded = false;
        });
    }
}
</script>