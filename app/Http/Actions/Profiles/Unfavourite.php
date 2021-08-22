<?php

namespace App\Http\Actions\Profiles;

use App\Models\FavouriteProfile;

class Unfavourite
{
    //Unfavourite a profile
    public function execute(int $id)
    {
        //Checking if the user has already liked the post
        $isFavourite = FavouriteProfile::where('id', $id)->count();
        
        //If the user has already liked the post
        if ($isFavourite === 1) {
            //Delete the favourite
            FavouriteProfile::where('id', $id)
                ->delete();

            return 'Favourite removed!';
        }
    }
}
