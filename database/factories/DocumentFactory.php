<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_category_id' => 1,
            'created_by_user_id'=>1,
            'title' => $this->faker->sentence,
            'file_path' => 'documents/1/file.pdf',
        ];
    }
}
