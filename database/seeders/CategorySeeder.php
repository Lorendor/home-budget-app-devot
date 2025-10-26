<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    
    public function run(): void
    {
        $predefinedCategories = [
            [
                'name' => 'Food & Dining',
                'is_predefined' => true
            ],
            [
                'name' => 'Transportation',
                'is_predefined' => true
            ],
            [
                'name' => 'Housing',
                'is_predefined' => true
            ],
            [
                'name' => 'Entertainment',
                'is_predefined' => true
            ],
            [
                'name' => 'Healthcare',
                'is_predefined' => true
            ],
            [
                'name' => 'Shopping',
                'is_predefined' => true
            ],
            [
                'name' => 'Education',
                'is_predefined' => true
            ],
            [
                'name' => 'Gifts & Donations',
                'is_predefined' => true
            ],
            [
                'name' => 'Utilities',
                'is_predefined' => true
            ],
            [
                'name' => 'Miscellaneous',
                'is_predefined' => true
            ]
        ];

        foreach ($predefinedCategories as $category) {
            Category::create($category);
        }
    }
}
