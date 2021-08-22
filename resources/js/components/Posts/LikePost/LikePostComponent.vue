<template>
    <span>
        <!-- Like Or Unlike A Post -->
        <i @click="likeOrUnlikeAPost" :class="postLikeIcon"></i>
        {{likes.length}}
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../app';
export default {
    props:{
        postIndex: Number,
        postId: Number,
        postCreatorId: Number,
        loggedInUserId: Number,
        likes: Array
    },
    methods:{
        ...mapActions('posts', ['getPosts', 'likePost', 'unlikePost']),
        //Liking or unliking a post
        likeOrUnlikeAPost(){
            //Data
            const data = {
                'postIndex': this.postIndex,
                'post_id': this.postId,
                'user_id': this.loggedInUserId
            };

            if(this.likes.find(post => post.user_id === this.loggedInUserId)){
                //If the user has already liked the post
                this.unlikePost(this.postId)
                .then(() => {
                    this.getPosts(this.$store.state.posts.posts.current_page);
                })
                .catch(() => {
                    bus.$emit('post_error');
                });
            }else{
                //If the user hasn't already liked the post
                this.likePost(data).then(() => {
                    this.getPosts(this.$store.state.posts.posts.current_page);
                })
                .catch(() => {
                    bus.$emit('post_error');
                });
            }
        }
    },
    computed:{
        //Checking which icon needs to be displayed
        postLikeIcon(){
            return this.likes.find(post => post.user_id === this.loggedInUserId) ? 'fas fa-heart-broken cursor-pointer' : 'fas fa-heart cursor-pointer';
        }
    }
}
</script>