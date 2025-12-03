<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can get all tasks', function () {
    Task::factory()->create(['title' => 'Task 1', 'description' => 'Desc 1', 'task_date' => '2023-01-01']);
    Task::factory()->create(['title' => 'Task 2', 'description' => 'Desc 2', 'task_date' => '2023-01-02']);

    $response = $this->getJson('/api/task');

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure(['data', 'meta']);
});

it('can filter tasks by title', function () {
    Task::factory()->create(['title' => 'Unique Task', 'description' => 'Desc 1', 'task_date' => '2023-01-01']);
    Task::factory()->create(['title' => 'Another Task', 'description' => 'Desc 2', 'task_date' => '2023-01-02']);

    $response = $this->getJson('/api/task?title=Unique');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['title' => 'Unique Task']);
});

it('can filter tasks by date', function () {
    Task::factory()->create(['title' => 'Task 1', 'description' => 'Desc 1', 'task_date' => '2023-01-05']);
    Task::factory()->create(['title' => 'Task 2', 'description' => 'Desc 2', 'task_date' => '2023-01-06']);

    $response = $this->getJson('/api/task?task_date=2023-01-06');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['title' => 'Task 2']);
});

it('can paginate tasks', function () {
    Task::factory()->count(15)->create();

    $response = $this->getJson('/api/task?page=1&per_page=10');

    $response->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('meta.current_page', 1)
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.total', 15);

    $response = $this->getJson('/api/task?page=2&per_page=10');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data')
        ->assertJsonPath('meta.current_page', 2);
});

it('can create a task', function () {
    $data = [
        'title' => 'New Task',
        'description' => 'New Description',
        'task_date' => '2023-01-03',
    ];

    $response = $this->postJson('/api/task', $data);

    $response->assertStatus(201)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('tasks', $data);
});

it('can show a task', function () {
    $task = Task::factory()->create(['title' => 'Task 1', 'description' => 'Desc 1', 'task_date' => '2023-01-01']);

    $response = $this->getJson("/api/task/{$task->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['title' => 'Task 1']);
});

it('can update a task', function () {
    $task = Task::factory()->create(['title' => 'Task 1', 'description' => 'Desc 1', 'task_date' => '2023-01-01']);
    $data = ['title' => 'Updated Task'];

    $response = $this->putJson("/api/task/{$task->id}", $data);

    $response->assertStatus(200);

    $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Task']);
});

it('can delete a task', function () {
    $task = Task::factory()->create(['title' => 'Task 1', 'description' => 'Desc 1', 'task_date' => '2023-01-01']);

    $response = $this->deleteJson("/api/task/{$task->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
