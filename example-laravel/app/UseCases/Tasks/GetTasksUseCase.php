<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Illuminate\Support\Facades\Log;
use Exception;

class GetTasksUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getAll(array $filters = [], array $pagination = []): array
    {
        try {
            return $this->taskRepository->getAll($filters, $pagination);
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("UseCase Error: " . $e->getMessage());
        }
    }
}
