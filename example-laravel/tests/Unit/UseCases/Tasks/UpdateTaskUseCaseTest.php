<?php

use App\Repositories\MySql\TaskRepository;
use App\UseCases\Task\UpdateTaskUseCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates a task successfully', function () {
    TaskCategory::factory()->create(['id' => 2]);
    $repository = Mockery::mock(TaskRepository::class);
    $id = 1;
    $data = [
        'title' => 'Updated Task',
        'description' => 'Updated Description',
        'task_date' => '2023-01-02',
        'task_category_id' => 2,
    ];

    $repository->shouldReceive('update')
        ->once()
        ->with($id, $data)
        ->andReturn(true);

    $useCase = new UpdateTaskUseCase($repository);
    $result = $useCase->update($id, $data);

    expect($result)->toBeTrue();
});

it('throws validation exception for invalid data', function () {
    $repository = Mockery::mock(TaskRepository::class);
    $useCase = new UpdateTaskUseCase($repository);

    $useCase->update(1, ['title' => 123]); // Invalid title type
})->throws(ValidationException::class);

it('logs error and throws exception when repository fails', function () {
    Log::shouldReceive('error')->once();

    $repository = Mockery::mock(TaskRepository::class);
    $repository->shouldReceive('update')
        ->once()
        ->andThrow(new Exception('Database error'));

    $useCase = new UpdateTaskUseCase($repository);
    $useCase->update(1, ['title' => 'Updated Task']);
})->throws(Exception::class, 'UseCase Error: Database error');
