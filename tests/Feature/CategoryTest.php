<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
    }

    public function test_can_create_category(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_category(): void
    {
        $category = Category::create(['name' => 'Test Category']);

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Updated Category',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::create(['name' => 'Test Category']);

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(200);
    }
}
