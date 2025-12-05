<?php

namespace App\Repositories\MySql;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TaskCategory;
use Exception;

class TaskCategoryRepository
{
    public function getAll(): array
    {
        try {
            return DB::select("SELECT * FROM task_categories");
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("Error fetching task categories: " . $e->getMessage());
        }
    }

    public function GetByID(int $id): ?object
    {
        try {
            $result = DB::select('SELECT * FROM task_categories WHERE id = ?', [$id]);
            return $result[0] ?? null;
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("Error finding task category: " . $e->getMessage());
        }
    }

    public function create(array $data): object
    {
        try {
            return TaskCategory::create($data);
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("Error creating task category: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $category = TaskCategory::find($id);
            if (!$category) {
                return false;
            }
            return $category->update($data);
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("Error updating task category: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            $category = TaskCategory::find($id);
            if (!$category) {
                return false;
            }
            return $category->delete();
        } catch (Exception $e) {
            Log::error(
                message: "error",
                context: [
                    'method' => __METHOD__,
                    'message' => $e->getMessage()
                ]
            );
            throw new Exception("Error deleting task category: " . $e->getMessage());
        }
    }
}
