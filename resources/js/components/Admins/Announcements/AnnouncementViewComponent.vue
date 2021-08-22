<template>
    <div>
        <CreateAnnouncement/>
        <ShowAnnouncement :search="search"/>
    </div>
</template>

<script>
import CreateAnnouncement from './CreateAnnouncementComponent';
import ShowAnnouncement from './ShowAnnouncementsComponent';
export default {
    components:{CreateAnnouncement, ShowAnnouncement},
    props:{
        search: String
    }
}
</script>