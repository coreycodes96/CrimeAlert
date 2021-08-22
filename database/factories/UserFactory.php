<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->name(),
            'surname' => $this->faker->name(),
            'username' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'dob' => $this->faker->date($format = 'Y-m-d', $max = '2003-12-31'),
            'admin' => 0,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
