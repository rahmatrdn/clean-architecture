<?php

use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list task categories', function () {
    TaskCategory::factory()->count(3)->create();

    $response = $this->getJson('/api/task-category');

    $response->assertStatus(200)
        ->assertJsonCount(3);
});

test('can create task category', function () {
    $data = ['name' => 'New Category'];

    $response = $this->postJson('/api/task-category', $data);

    $response->assertStatus(201)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('task_categories', $data);
});

test('can show task category', function () {
    $category = TaskCategory::factory()->create();

    $response = $this->getJson("/api/task-category/{$category->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['id' => $category->id, 'name' => $category->name]);
});

test('can update task category', function () {
    $category = TaskCategory::factory()->create();
    $data = ['name' => 'Updated Category'];

    $response = $this->putJson("/api/task-category/{$category->id}", $data);

    $response->assertStatus(200);

    $this->assertDatabaseHas('task_categories', array_merge(['id' => $category->id], $data));
});

test('can delete task category', function () {
    $category = TaskCategory::factory()->create();

    $response = $this->deleteJson("/api/task-category/{$category->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('task_categories', ['id' => $category->id]);
});
