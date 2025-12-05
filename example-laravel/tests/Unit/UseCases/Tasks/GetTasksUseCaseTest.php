<?php

use App\Repositories\MySql\TaskRepository;
use App\UseCases\Tasks\GetTasksUseCase;
use Illuminate\Support\Facades\Log;


it('gets all tasks successfully', function () {
    $repository = Mockery::mock(TaskRepository::class);
    $filters = ['title' => 'Test'];
    $pagination = ['page' => 1];
    $expectedResult = ['data' => [], 'meta' => []];

    $repository->shouldReceive('getAll')
        ->once()
        ->with($filters, $pagination)
        ->andReturn($expectedResult);

    $useCase = new GetTasksUseCase($repository);
    $result = $useCase->getAll($filters, $pagination);

    expect($result)->toBe($expectedResult);
});

it('logs error and throws exception when repository fails', function () {
    Log::shouldReceive('error')->once();

    $repository = Mockery::mock(TaskRepository::class);
    $repository->shouldReceive('getAll')
        ->once()
        ->andThrow(new Exception('Database error'));

    $useCase = new GetTasksUseCase($repository);
    $useCase->getAll();
})->throws(Exception::class, 'UseCase Error: Database error');
