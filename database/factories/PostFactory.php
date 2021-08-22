<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 day');
        return [
            'user_id' => User::all()->random()->id,
            'body' => $this->faker->text($maxNbChars = 1000),
            'location' => $this->faker->city(),
            'media' => $this->faker->imageUrl($width = 640, $height = 480),
            'status' => 0,
            'created_at'=> $date,
            'updated_at'=> $date
        ];
    }
}
