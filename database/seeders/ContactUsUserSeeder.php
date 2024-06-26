<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactUsUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ContactUsUser::factory(5)->create();
    }
}
