<?php

namespace App\UseCases\Tasks;

use App\Repositories\MySql\TaskRepository;
use Illuminate\Support\Facades\Log;
use Exception;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateTaskUseCase
{
    public function __construct(
        protected TaskRepository $taskRepository
    ) {}

    public function create(array $data): object
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'task_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return $this->taskRepository->create($data);
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
