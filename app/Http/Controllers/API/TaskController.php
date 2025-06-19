<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    // Get all tasks, latest first
    public function index()
    {
        return Task::orderByDesc('created_at')->get();
    }

    // Store a new task
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string',
            'createdAt' => 'nullable|date',
        ]);

        return Task::create([
            'title' => $data['title'],
            'status' => $data['status'],
            'created_at' => $data['createdAt'] ?? now(),
        ]);
    }

    // Update task status
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $task->update($data);
        return $task;
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
