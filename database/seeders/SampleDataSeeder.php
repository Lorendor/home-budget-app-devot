<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::create([
            'name' => 'TestUser5',
            'email' => 'testuser5@example.com',
            'password' => Hash::make('password123'),
            'balance' => 1000.00
        ]);

        Income::create([
            'user_id' => $user->id,
            'description' => 'Salary',
            'amount' => 2000.00
        ]);

        $category = Category::first();
        Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'description' => 'Shopping',
            'amount' => 50.00
        ]);

        $this->command->info('Simple sample data created!');
        $this->command->info('User: testuser5@example.com / password123');
    }
}
