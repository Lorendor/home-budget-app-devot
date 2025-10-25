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
                'description' => 'Groceries, restaurants, and food expenses',
                'is_predefined' => true
            ],
            [
                'name' => 'Transportation',
                'description' => 'Car expenses, fuel, public transport, and travel',
                'is_predefined' => true
            ],
            [
                'name' => 'Housing',
                'description' => 'Rent, mortgage, utilities, and home maintenance',
                'is_predefined' => true
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Movies, games, hobbies, and leisure activities',
                'is_predefined' => true
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical expenses, pharmacy, and health services',
                'is_predefined' => true
            ],
            [
                'name' => 'Shopping',
                'description' => 'Clothing, electronics, and general shopping',
                'is_predefined' => true
            ],
            [
                'name' => 'Education',
                'description' => 'Books, courses, and educational expenses',
                'is_predefined' => true
            ],
            [
                'name' => 'Gifts & Donations',
                'description' => 'Gifts for others and charitable donations',
                'is_predefined' => true
            ],
            [
                'name' => 'Utilities',
                'description' => 'Electricity, water, internet, and phone bills',
                'is_predefined' => true
            ],
            [
                'name' => 'Miscellaneous',
                'description' => 'Other expenses that do not fit into specific categories',
                'is_predefined' => true
            ]
        ];

        foreach ($predefinedCategories as $category) {
            Category::create($category);
        }
    }
}
