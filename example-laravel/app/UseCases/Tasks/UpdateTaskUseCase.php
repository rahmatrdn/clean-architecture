<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Exception;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateTaskUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function execute(int $id, array $data): bool
    {
        $validator = Validator::make($data, [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'task_date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return $this->taskRepository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception("UseCase Error: " . $e->getMessage());
        }
    }
}
