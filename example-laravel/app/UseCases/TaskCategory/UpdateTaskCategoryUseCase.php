<?php

namespace App\UseCases\TaskCategory;

use App\Repositories\MySql\TaskCategoryRepository;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateTaskCategoryUseCase
{
    public function __construct(
        protected TaskCategoryRepository $repository
    ) {}

    public function update(int $id, array $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:task_categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return $this->repository->update($id, $data);
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
