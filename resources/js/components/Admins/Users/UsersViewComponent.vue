<template>
    <div>
        <ShowUsers :search="search"/>
    </div>
</template>

<script>
import ShowUsers from './ShowUsersComponent';
export default {
    components:{ShowUsers},
    props:{
        search: String
    }
}
</script>