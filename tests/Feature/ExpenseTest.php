<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_expenses(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/expenses');

        $response->assertStatus(200);
    }

    public function test_can_create_expense(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category']);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/expenses', [
            'description' => 'Test expense',
            'amount' => 50.00,
            'categoryId' => $category->id,
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_expense(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category']);
        $expense = Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'description' => 'Test expense',
            'amount' => 50.00
        ]);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson("/api/expenses/{$expense->id}", [
            'description' => 'Updated expense',
            'amount' => 75.00,
            'categoryId' => $category->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_expense(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Test Category']);
        $expense = Expense::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'description' => 'Test expense',
            'amount' => 50.00
        ]);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson("/api/expenses/{$expense->id}");

        $response->assertStatus(200);
    }
}
