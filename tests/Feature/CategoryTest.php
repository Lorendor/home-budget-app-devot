<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::create(['name' => 'Test Category']);
    }

    public function test_can_get_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
    }

    public function test_can_create_category(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'New Category',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_category(): void
    {
        $response = $this->putJson("/api/categories/{$this->category->id}", [
            'name' => 'Updated Category',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_category(): void
    {
        $response = $this->deleteJson("/api/categories/{$this->category->id}");

        $response->assertStatus(200);
    }
}
