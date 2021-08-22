<template>
    <span>
        <!-- Favourite A Users Profile -->
        <i v-if="userId !== profileId" @click="favouriteOrUnfavouriteProfile" :class="favouriteIcon"></i>
    </span>
</template>

<script>
import { mapActions } from 'vuex';
import {bus} from '../../../../app';
export default {
    props:{
        userId: Number,
        profileId: Number,
        username: String,
        favourite: Array
    },
    methods:{
        ...mapActions('profile', ['getUserProfileInformation', 'favouriteProfile', 'unfavouriteProfile']),
        //Favourite or unfavourite a users profile
        favouriteOrUnfavouriteProfile(){
            //Data
            const data = {
                'user_id': this.userId,
                'profile_id': this.profileId
            };

            if(this.favourite.find(favourite => favourite.user_id === this.userId)){
                //Getting the favourite ID
                const getFavouriteId = this.favourite.find(favourite => favourite.user_id === this.userId && favourite.profile_id === this.profileId).id;

                //If the user has already liked the profile
                this.unfavouriteProfile(getFavouriteId)
                .then(() => {
                    this.getUserProfileInformation(this.username);
                })
                .catch(() => {
                    bus.$emit('profile_error');
                })
            }else{
                //If the user hasn't already liked the profile
                this.favouriteProfile(data)
                .then(() => {
                    this.getUserProfileInformation(this.username);
                })
                .catch(() => {
                    bus.$emit('profile_error');
                })
            }
        }
    },
    computed:{
        //Checking which icon to use
        favouriteIcon(){
            return this.favourite.find(favourite => favourite.user_id === this.userId) ? 'fas fa-star text-sm cursor-pointer' : 'far fa-star text-sm cursor-pointer';
        }
    }
}
</script>