<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::factory(1)->create([
            'username' => 'Admin1',
            'email' => 'admin1@test.co.uk',
            'admin' => 1
        ]);
    }
}
