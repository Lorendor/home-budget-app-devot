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

    protected $user;
    protected $category;
    protected $expense;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::create(['name' => 'Test Category']);
        $this->expense = Expense::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'Test expense',
            'amount' => 50.00
        ]);
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_get_expenses(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/expenses');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'status_code'
        ]);
        $response->assertJson(['success' => true]);
    }

    public function test_can_create_expense(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/expenses', [
            'description' => 'New expense',
            'amount' => 75.00,
            'categoryId' => $this->category->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'status_code'
        ]);
        $response->assertJson(['success' => true]);
    }

    public function test_can_update_expense(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->putJson("/api/expenses/{$this->expense->id}", [
            'description' => 'Updated expense',
            'amount' => 75.00,
            'categoryId' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'status_code'
        ]);
        $response->assertJson(['success' => true]);
    }

    public function test_can_delete_expense(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->deleteJson("/api/expenses/{$this->expense->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'status_code'
        ]);
        $response->assertJson(['success' => true]);
    }
}
