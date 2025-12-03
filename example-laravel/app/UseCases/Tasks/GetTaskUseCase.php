<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Illuminate\Support\Facades\Log;
use Exception;

class GetTaskUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function getByID(int $id): ?object
    {
        try {
            return $this->taskRepository->GetByID($id);
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
