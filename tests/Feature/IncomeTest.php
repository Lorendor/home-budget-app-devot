<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Income;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $income;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->income = Income::create([
            'user_id' => $this->user->id,
            'description' => 'Test Income',
            'amount' => 1000.00
        ]);
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_get_incomes(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->getJson('/api/incomes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'status_code'
        ]);
        $response->assertJson(['success' => true]);
    }

    public function test_can_create_income(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->postJson('/api/incomes', [
            'description' => 'New Income',
            'amount' => 1500.00,
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

    public function test_can_update_income(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->putJson("/api/incomes/{$this->income->id}", [
            'description' => 'Updated Income',
            'amount' => 1500.00,
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

    public function test_can_delete_income(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->deleteJson("/api/incomes/{$this->income->id}");

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
