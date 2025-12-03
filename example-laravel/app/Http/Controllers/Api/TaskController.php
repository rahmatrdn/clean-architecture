<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\Tasks\CreateTaskUseCase;
use App\UseCases\Tasks\DeleteTaskUseCase;
use App\UseCases\Tasks\GetTasksUseCase;
use App\UseCases\Tasks\GetTaskUseCase;
use App\UseCases\Tasks\UpdateTaskUseCase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        protected GetTasksUseCase $getTasksUseCase,
        protected GetTaskUseCase $getTaskUseCase,
        protected CreateTaskUseCase $createTaskUseCase,
        protected UpdateTaskUseCase $updateTaskUseCase,
        protected DeleteTaskUseCase $deleteTaskUseCase
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['title', 'task_date']);
            $pagination = [
                'page' => $request->input('page', 1),
                'per_page' => $request->input('per_page', 10),
            ];
            $tasks = $this->getTasksUseCase->execute($filters, $pagination);
            return response()->json($tasks);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $task = $this->createTaskUseCase->execute($request->all());
            return response()->json($task, 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $task = $this->getTaskUseCase->execute((int) $id);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            return response()->json($task);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $updated = $this->updateTaskUseCase->execute((int) $id, $request->all());
            if (!$updated) {
                return response()->json(['error' => 'Task not found or update failed'], 404);
            }
            return response()->json(['message' => 'Task updated successfully']);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $deleted = $this->deleteTaskUseCase->execute((int) $id);
            if (!$deleted) {
                return response()->json(['error' => 'Task not found or delete failed'], 404);
            }
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }
}
