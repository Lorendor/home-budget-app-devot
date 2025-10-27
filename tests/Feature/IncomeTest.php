<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Income;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_incomes(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/incomes');

        $response->assertStatus(200);
    }

    public function test_can_create_income(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/incomes', [
            'description' => 'Test Income',
            'amount' => 1000.00,
            'source' => 'Test Source',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_income(): void
    {
        $user = User::factory()->create();
        $income = Income::create([
            'user_id' => $user->id,
            'description' => 'Test Income',
            'amount' => 1000.00,
            'source' => 'Test Source'
        ]);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson("/api/incomes/{$income->id}", [
            'description' => 'Updated Income',
            'amount' => 1500.00,
            'source' => 'Updated Source',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_income(): void
    {
        $user = User::factory()->create();
        $income = Income::create([
            'user_id' => $user->id,
            'description' => 'Test Income',
            'amount' => 1000.00,
            'source' => 'Test Source'
        ]);
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson("/api/incomes/{$income->id}");

        $response->assertStatus(200);
    }
}
