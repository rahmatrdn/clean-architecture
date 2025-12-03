<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Exception;

class GetTaskUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function execute(int $id): ?object
    {
        try {
            return $this->taskRepository->GetByID($id);
        } catch (Exception $e) {
            throw new Exception("UseCase Error: " . $e->getMessage());
        }
    }
}
