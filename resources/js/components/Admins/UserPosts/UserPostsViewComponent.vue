<template>
    <div>
        <ShowUserPosts :search="search"/>
    </div>
</template>

<script>
import ShowUserPosts from './ShowUserPostsComponent';
export default {
    components:{ShowUserPosts},
    props:{
        search: String
    }
}
</script>