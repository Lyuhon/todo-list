<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    // Получить список задач текущего пользователя
    public function index(): JsonResponse
    {
        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Tasks retrieved successfully!',
            'tasks' => $tasks
        ]);
    }

    // Создать новую задачу
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Auth::user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_completed' => false,
        ]);

        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task
        ], 201);
    }

    // Получить задачу по ID
    public function show($id): JsonResponse
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json([
            'message' => 'Task retrieved successfully!',
            'task' => $task
        ]);
    }

    // Обновить задачу
    public function update(Request $request, $id): JsonResponse
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|nullable',
            'is_completed' => 'sometimes|boolean',
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully!',
            'task' => $task
        ]);
    }

    // Удалить задачу
    public function destroy($id): JsonResponse
    {
        $task = Auth::user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully!']);
    }
}