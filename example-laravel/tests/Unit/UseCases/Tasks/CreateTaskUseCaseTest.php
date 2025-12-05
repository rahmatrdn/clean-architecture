<?php

use App\Repositories\MySql\TaskRepository;
use App\UseCases\Tasks\CreateTaskUseCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


use App\Models\TaskCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a task successfully', function () {
    TaskCategory::factory()->create(['id' => 1]);
    $repository = Mockery::mock(TaskRepository::class);
    $data = [
        'title' => 'Test Task',
        'description' => 'Test Description',
        'task_date' => '2023-01-01',
        'task_category_id' => 1,
    ];
    $expectedTask = (object) array_merge(['id' => 1], $data);

    $repository->shouldReceive('create')
        ->once()
        ->with($data)
        ->andReturn($expectedTask);

    $useCase = new CreateTaskUseCase($repository);
    $result = $useCase->create($data);

    expect($result)->toBe($expectedTask);
});

it('throws validation exception for invalid data', function () {
    $repository = Mockery::mock(TaskRepository::class);
    $useCase = new CreateTaskUseCase($repository);

    $useCase->create([]);
})->throws(ValidationException::class);

it('logs error and throws exception when repository fails', function () {
    Log::shouldReceive('error')->once();

    $repository = Mockery::mock(TaskRepository::class);
    $data = [
        'title' => 'Test Task',
        'description' => 'Test Description',
        'task_date' => '2023-01-01',
    ];

    $repository->shouldReceive('create')
        ->once()
        ->andThrow(new Exception('Database error'));

    $useCase = new CreateTaskUseCase($repository);
    $useCase->create($data);
})->throws(Exception::class, 'UseCase Error: Database error');
