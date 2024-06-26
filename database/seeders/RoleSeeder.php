<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin=Role::firstOrCreate(['name'=>'admin'],['name'=>'admin']);
        $roleUser=Role::firstOrCreate(['name'=>'user'],['name'=>'user']);
        $roleCompany=Role::firstOrCreate(['name'=>'company'],['name'=>'company']);

    }
}
