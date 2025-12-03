<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Illuminate\Support\Facades\Log;
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
