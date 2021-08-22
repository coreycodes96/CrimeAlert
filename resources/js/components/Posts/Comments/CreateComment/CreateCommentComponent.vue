<template>
    <div class="absolute bottom-0 left-0 flex w-full h-28">
        <!-- Comment Textarea -->
        <textarea class="pt-1 pl-3 w-full h-28 text-black resize-none focus:outline-none" placeholder="Comment..." v-model.trim="body"></textarea>
        
        <!-- Button -->
        <button @click="createAComment" class="p-2 bg-indigo-800 text-white"><i class="fas fa-paper-plane w-20 text-xl"></i></button>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../app';
export default {
    props:{
        loggedInUserId: Number,
        postId: Number
    },
    data(){
        return{
            body: '',
        }
    },
    methods:{
        ...mapActions('comments', ['getComments', 'createComment']),
        //Making a request to create a comment
        createAComment(){
            //Checking if the body is empty or is not over 2500 characters
            if(this.body !== '' && this.body.length >! 2500){
                const data = {
                    'user_id': this.loggedInUserId,
                    'post_id': this.postId,
                    'body': this.body
                };

                this.createComment(data)
                .then(() => {
                    this.getComments(data.post_id);
                    this.body = '';
                    bus.$emit('add_one_too_comments', this.postId);
                })
                .catch(() => {
                    bus.$emit('comment_error');
                })
            }
        }
    }
}
</script>