<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteProfile extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'profile_id'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }
}
