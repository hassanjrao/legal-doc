<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        // assign role to user
        $user = User::find(1);
        $user->update('email_verified_at', now());
        // $user->assignRole('admin');

        // $user = User::find(2);
        // $user->assignRole('user');

        // $user = User::find(3);
        // $user->assignRole('company');
    }
}
