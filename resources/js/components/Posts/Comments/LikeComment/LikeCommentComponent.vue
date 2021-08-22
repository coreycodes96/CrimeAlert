<template>
    <span class="flex justify-center items-center flex-row">
        <!-- Like Or Unlike Comment -->
        <i @click="likeOrUnlikeAComment" :class="commentLikeIcon"></i>

        <!-- Comment Like Length -->
        <div class="mt-0.5">{{commentLikes.length}}</div>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../app';
export default {
    props:{
        commentIndex: Number,
        commentId: Number,
        commentCreatorId: Number,
        loggedInUserId: Number,
        postId: Number,
        commentLikes: Array
    },
    methods:{
        ...mapActions('comments', ['getComments', 'likeComment', 'unlikeComment']),
        //Like or unlike a comment
        likeOrUnlikeAComment(){
            //Data
            const data = {
                'commentIndex': this.commentIndex,
                'comment_id': this.commentId,
                'user_id': this.loggedInUserId
            };

            if(this.commentLikes.find(comment => comment.user_id === this.loggedInUserId)){
                //If the user has already liked the comment
                this.unlikeComment(data.comment_id)
                .then(() => {
                    this.getComments(this.postId);
                })
                .catch(() => {
                    bus.$emit('comment_error');
                });
            }else{
                //If the user hasn't already liked the comment
                this.likeComment(data)
                .then(() => {
                    this.getComments(this.postId);
                })
                .catch(() => {
                    bus.$emit('comment_error');
                });
            }
        }
    },
    computed:{
        //Checking which icon to use
        commentLikeIcon(){
            return this.commentLikes.find(comment => comment.user_id === this.loggedInUserId) ? 'mt-1 mr-2 fas fa-heart-broken cursor-pointer' : 'mt-1 mr-2 fas fa-heart cursor-pointer';
        }
    }
}
</script>