<?php

use App\Repositories\MySql\TaskRepository;
use App\UseCases\Tasks\GetTaskUseCase;
use Illuminate\Support\Facades\Log;


it('finds a task successfully', function () {
    $repository = Mockery::mock(TaskRepository::class);
    $id = 1;
    $expectedTask = (object) ['id' => 1, 'title' => 'Test Task'];

    $repository->shouldReceive('GetByID')
        ->once()
        ->with($id)
        ->andReturn($expectedTask);

    $useCase = new GetTaskUseCase($repository);
    $result = $useCase->getByID($id);

    expect($result)->toBe($expectedTask);
});

it('logs error and throws exception when repository fails', function () {
    Log::shouldReceive('error')->once();

    $repository = Mockery::mock(TaskRepository::class);
    $repository->shouldReceive('GetByID')
        ->once()
        ->andThrow(new Exception('Database error'));

    $useCase = new GetTaskUseCase($repository);
    $useCase->getByID(1);
})->throws(Exception::class, 'UseCase Error: Database error');
