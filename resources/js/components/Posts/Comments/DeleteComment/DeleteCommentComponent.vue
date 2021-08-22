<template>
    <span>
        <!-- Loader -->
        <div v-if="loading" class="absolute top-0 left-0 flex justify-center bg-indigo-800 items-center w-full h-full z-10">
            <div class="p-3 rounded text-white">
                <i class="fas fa-spinner animate-spin text-3xl"></i>
            </div>
        </div>

        <!-- Delete A Comment -->
        <i @click="deleteAComment" class="mt-4 fas fa-trash cursor-pointer text-red-600"></i>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../app';
export default {
    props:{
        commentIndex: Number,
        commentId: Number,
        postId: Number
    },
    data(){
        return {
            loading: false
        }
    },
    methods:{
        ...mapActions('comments', ['getComments', 'deleteComment']),
        //Making a request to delete a comment
        deleteAComment(){
            const data = {
                'comment_index': this.commentIndex,
                'comment_id': this.commentId,
            };

            this.loading = true;

            this.deleteComment(data)
            .then(() => {
                this.getComments(this.postId);
                this.loading = false;

                bus.$emit('take_one_away_from_comments', this.postId);
            })
            .catch(() => {
                this.loading = false;
                bus.$emit('comment_error');
            })
        }
    }
}
</script>