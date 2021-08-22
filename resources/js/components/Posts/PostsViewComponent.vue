<template>
    <div>
        <!-- Display Posts -->
        <ShowPosts :logged-in-user-id="this.loggedInUserId"/>
        
        <!-- Create A Post -->
        <CreatePost :logged-in-user-id="this.loggedInUserId"/>
    </div>
</template>

<script>
import ShowPosts from './ShowPosts/ShowPostsComponent';
import CreatePost from './CreatePost/CreatePostComponent';
export default {
    props:{
        'loggedInUserId': Number
    },
    components:{ShowPosts, CreatePost},
}
</script>