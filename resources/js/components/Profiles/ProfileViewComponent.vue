<template>
    <ShowProfile :logged-in-user-id="loggedInUserId" :logged-in-user-firstname="loggedInUserFirstname" :logged-in-user-surname="loggedInUserSurname" :logged-in-user-username="loggedInUserUsername" :username="username"></ShowProfile>
</template>

<script>
import ShowProfile from './ShowProfile/ShowProfileComponent';
export default {
    components:{ShowProfile},
    props:{
        loggedInUserId: Number,
        loggedInUserFirstname: String,
        loggedInUserSurname: String,
        loggedInUserUsername: String
    },
    data(){
        return{
            username: window.location.pathname.split('/')[2]
        }
    },
}
</script>