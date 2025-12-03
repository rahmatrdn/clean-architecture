<?php

namespace App\Repositories\MySql;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Exception;

class TaskRepository
{
    public function getAll(array $filters = [], array $pagination = []): array
    {
        try {
            $query = "SELECT * FROM tasks";
            $countQuery = "SELECT COUNT(*) as total FROM tasks";
            $bindings = [];
            $conditions = [];

            if (!empty($filters['title'])) {
                $conditions[] = "title LIKE ?";
                $bindings[] = '%' . $filters['title'] . '%';
            }

            if (!empty($filters['task_date'])) {
                $conditions[] = "task_date = ?";
                $bindings[] = $filters['task_date'];
            }

            if (count($conditions) > 0) {
                $whereClause = " WHERE " . implode(' AND ', $conditions);
                $query .= $whereClause;
                $countQuery .= $whereClause;
            }

            // Get total count
            $total = DB::select($countQuery, $bindings)[0]->total;

            // Apply pagination
            $page = $pagination['page'] ?? 1;
            $perPage = $pagination['per_page'] ?? 10;
            $offset = ($page - 1) * $perPage;

            $query .= " LIMIT ? OFFSET ?";
            $bindings[] = $perPage;
            $bindings[] = $offset;

            $data = DB::select($query, $bindings);

            return [
                'data' => $data,
                'meta' => [
                    'current_page' => (int) $page,
                    'per_page' => (int) $perPage,
                    'total' => $total,
                    'last_page' => ceil($total / $perPage),
                ]
            ];
        } catch (Exception $e) {
            Log::error("Error in " . __METHOD__ . ": " . $e->getMessage());
            throw new Exception("Error fetching tasks: " . $e->getMessage());
        }
    }

    public function GetByID(int $id): ?object
    {
        try {
            $result = DB::select('SELECT * FROM tasks WHERE id = ?', [$id]);
            return $result[0] ?? null;
        } catch (Exception $e) {
            Log::error("Error in " . __METHOD__ . ": " . $e->getMessage());
            throw new Exception("Error finding task: " . $e->getMessage());
        }
    }

    public function create(array $data): object
    {
        try {
            return Task::create($data);
        } catch (Exception $e) {
            Log::error("Error in " . __METHOD__ . ": " . $e->getMessage());
            throw new Exception("Error creating task: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return false;
            }
            return $task->update($data);
        } catch (Exception $e) {
            Log::error("Error in " . __METHOD__ . ": " . $e->getMessage());
            throw new Exception("Error updating task: " . $e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            $task = Task::find($id);
            if (!$task) {
                return false;
            }
            return $task->delete();
        } catch (Exception $e) {
            Log::error("Error in " . __METHOD__ . ": " . $e->getMessage());
            throw new Exception("Error deleting task: " . $e->getMessage());
        }
    }
}
