<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Exception;

class DeleteTaskUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function execute(int $id): bool
    {
        try {
            return $this->taskRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception("UseCase Error: " . $e->getMessage());
        }
    }
}
