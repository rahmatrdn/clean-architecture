<?php

use App\Repositories\MySql\TaskRepository;
use App\UseCases\Task\DeleteTaskUseCase;
use Illuminate\Support\Facades\Log;


it('deletes a task successfully', function () {
    $repository = Mockery::mock(TaskRepository::class);
    $id = 1;

    $repository->shouldReceive('delete')
        ->once()
        ->with($id)
        ->andReturn(true);

    $useCase = new DeleteTaskUseCase($repository);
    $result = $useCase->delete($id);

    expect($result)->toBeTrue();
});

it('logs error and throws exception when repository fails', function () {
    Log::shouldReceive('error')->once();

    $repository = Mockery::mock(TaskRepository::class);
    $repository->shouldReceive('delete')
        ->once()
        ->andThrow(new Exception('Database error'));

    $useCase = new DeleteTaskUseCase($repository);
    $useCase->delete(1);
})->throws(Exception::class, 'UseCase Error: Database error');
