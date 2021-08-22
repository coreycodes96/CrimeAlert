<template>
    <span>
        <!-- Loader -->
        <div v-if="loading" class="absolute top-0 left-0 flex justify-center items-center bg-indigo-800 w-full h-full z-10">
            <div class="p-3 text-white">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </div>

        <!-- Delete A Post -->
        <i @click="deleteAPost" class="fas fa-trash cursor-pointer text-red-600"></i>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        postIndex: Number,
        postId: Number
    },
    data(){
        return{
            loading: false
        }
    },
    methods:{
        ...mapActions('posts', ['getPosts', 'deletePost']),
        //Making a request to delete a post
        deleteAPost(){
            //Data
            const data = {
                'post_id': this.postId,
                'post_index': this.postIndex
            };

            //Letting the user know a request is happening
            this.loading = true;
            this.deletePost(data)
            .then(() => {
                //Letting the user know a request is happening
                this.loading = false;

                //Getting the posts
                this.getPosts(this.$store.state.posts.posts.current_page);
            })
            .catch(() => {
                //Letting the user know a request is happening
                this.loading = false;

                //Adding an error message
                bus.$emit('post_error');
            });
        }
    }
}
</script>