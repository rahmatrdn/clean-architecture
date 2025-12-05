<?php

namespace App\UseCases\TaskCategory;

use App\Repositories\MySql\TaskCategoryRepository;
use Illuminate\Support\Facades\Log;
use Exception;

class DeleteTaskCategoryUseCase
{
    public function __construct(
        protected TaskCategoryRepository $repository
    ) {}

    public function delete(int $id): bool
    {
        try {
            return $this->repository->delete($id);
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
