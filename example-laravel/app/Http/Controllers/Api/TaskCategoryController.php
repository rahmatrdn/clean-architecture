<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCases\TaskCategory\CreateTaskCategoryUseCase;
use App\UseCases\TaskCategory\DeleteTaskCategoryUseCase;
use App\UseCases\TaskCategory\GetTaskCategoriesUseCase;
use App\UseCases\TaskCategory\GetTaskCategoryUseCase;
use App\UseCases\TaskCategory\UpdateTaskCategoryUseCase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskCategoryController extends Controller
{
    public function __construct(
        protected GetTaskCategoriesUseCase $getTaskCategoriesUseCase,
        protected GetTaskCategoryUseCase $getTaskCategoryUseCase,
        protected CreateTaskCategoryUseCase $createTaskCategoryUseCase,
        protected UpdateTaskCategoryUseCase $updateTaskCategoryUseCase,
        protected DeleteTaskCategoryUseCase $deleteTaskCategoryUseCase
    ) {}

    public function index(): JsonResponse
    {
        try {
            $categories = $this->getTaskCategoriesUseCase->getAll();
            return response()->json($categories);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $category = $this->createTaskCategoryUseCase->create($request->all());
            return response()->json($category, 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $category = $this->getTaskCategoryUseCase->getByID((int) $id);
            if (!$category) {
                return response()->json(['error' => 'Task Category not found'], 404);
            }
            return response()->json($category);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $updated = $this->updateTaskCategoryUseCase->update((int) $id, $request->all());
            if (!$updated) {
                return response()->json(['error' => 'Task Category not found or update failed'], 404);
            }
            return response()->json(['message' => 'Task Category updated successfully']);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $deleted = $this->deleteTaskCategoryUseCase->delete((int) $id);
            if (!$deleted) {
                return response()->json(['error' => 'Task Category not found or delete failed'], 404);
            }
            return response()->json(['message' => 'Task Category deleted successfully']);
        } catch (Exception $e) {
            return $this->sendErrorResponse();
        }
    }
}
