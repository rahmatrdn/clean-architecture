<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Exception;

class GetTasksUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function execute(array $filters = [], array $pagination = []): array
    {
        try {
            return $this->taskRepository->getAll($filters, $pagination);
        } catch (Exception $e) {
            throw new Exception("UseCase Error: " . $e->getMessage());
        }
    }
}
