<template>
    <span>
        <!-- Open Comments -->
        <i @click="openComments" class="fas fa-comments cursor-pointer"></i>

        <!-- Comment Count -->
        <span :ref="`commentCount${postId}`">{{commentCount}}</span>
        
        <!-- Comment Container -->
        <div ref="commentContainer" class="ml-min-100 p-5 fixed top-0 left-0 w-full h-screen bg-indigo-800 z-50">
            <!-- Close Comment Container -->
            <div class="absolute top-5 right-5 text-white">
                <i @click="closeComments" class="fas fa-times text-2xl cursor-pointer"></i>
            </div>

            <div class="mt-36 w-full h-350 bg-gray-100">
                <!-- Loader -->
                <div v-if="loading" class="mt-36 p-5 fixed top-0 left-0 w-full h-350">
                    <div class="p-3 bg-gray-100 rounded text-indigo-800 flex justify-center items-center w-full h-350">
                        <i class="fas fa-spinner animate-spin text-3xl"></i>
                    </div>
                </div>

                <!-- No Comments -->
                <template v-if="fetchComments.length === 0">
                    <p class="flex justify-center items-center w-full h-350 text-2xl text-indigo-800">No comments!</p>
                </template>

                <!-- Display Comments -->
                <template v-else>
                    <div class="p-5 w-full h-350 border-t-4 border-b-4 border-white overflow-y-scroll text-black">
                        <div v-for="(comment, commentIndex) in fetchComments" :key="comment.id">
                            <div class="relative my-5 p-3 bg-indigo-800 rounded text-white">
                                <div class="flex">
                                    <p class="w-full whitespace-pre-line">{{comment.body}}</p>
                                    <div class="mx-4 flex flex-col">
                                        <!-- Like Comment -->
                                        <LikeComment v-if="comment.like_comments" :comment-index="commentIndex" :comment-id="comment.id" :comment-creator-id="comment.user_id" :logged-in-user-id="loggedInUserId" :post-id="postId" :comment-likes="comment.like_comments"/>
                                        
                                        <!-- Delete Comment -->
                                        <DeleteComment v-if="loggedInUserId === comment.user_id" :comment-index="commentIndex" :comment-id="comment.id" :post-id="postId"/>
                                    </div>
                                </div>

                                <div v-if="comment.user" class="mt-4 text-sm"><b>Created By: <a :href="`http://192.168.1.114:8000/profile/${comment.user.username}`">{{comment.user.username}}</a></b></div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Create A Comment -->
                <CreateComment :logged-in-user-id="loggedInUserId" :post-id="postId"/>
            </div>
        </div>
    </span>
</template>

<script>
import CreateComment from '../CreateComment/CreateCommentComponent';
import LikeComment from '../LikeComment/LikeCommentComponent';
import DeleteComment from '../DeleteComment/DeleteCommentComponent';
import { mapActions, mapGetters } from 'vuex';
import {bus} from '../../../../app';
export default {
    props:{
        loggedInUserId: Number,
        postId: Number,
        commentCount: Number
    },
    components:{CreateComment, DeleteComment, LikeComment},
    data(){
        return{
            loading: false,
        }
    },
    methods:{
        ...mapActions('comments', ['getComments']),
        //Open Comments
        openComments(){
            tl.to(this.$refs.commentContainer, {marginLeft: 0, duration: 0.3, ease: "power3.out"});
            
            this.loading = true;

            this.getComments(this.postId).
            then(() => {
                this.loading = false;
            })
            .catch(() => {
                this.loading = false;
                bus.$emit('comment_error');
            })
        },
        //Close comments
        closeComments(){
            tl.to(this.$refs.commentContainer, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
        }
    },
    computed:{
        ...mapGetters('comments', ['fetchComments'])
    },
    created(){
        //Comment Error
        bus.$on('comment_error', () => {
            tl.to(this.$refs.commentContainer, {marginLeft: '-100%', duration: 0.3, ease: "power3.out"});
            bus.$emit('post_error');
        })

        //Add 1 to the comment count
        bus.$on('add_one_too_comments', id => {
            if(id === this.postId){
                this.$refs['commentCount'+id].innerText = parseInt(this.$refs['commentCount'+id].innerText) + 1;
            }
        })

        //Take 1 away from the comment count
        bus.$on('take_one_away_from_comments', id => {
            if(id === this.postId){
                this.$refs['commentCount'+id].innerText = parseInt(this.$refs['commentCount'+id].innerText) - 1;
            }
        })
    }
}
</script>