<?php

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentCategory::updateOrCreate(['id'=>1],['id'=>1,'name'=>'Cat 1']);

        DocumentCategory::updateOrCreate(['id'=>2],['id'=>2,'name'=>'Cat 2']);
    }
}
