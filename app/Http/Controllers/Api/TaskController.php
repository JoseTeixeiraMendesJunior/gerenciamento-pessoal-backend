<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tasks = $request->user()->tasks;

            return response()->json([
                'tasks' => $tasks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function store(TaskRequest $request)
    {
        try {

            $data = $request->only([
                'name',
                'description',
                'due_date',
                'priority',
                'status',
                'type',
            ]);
            $task = $request->user()->tasks()->create($data);

            return response()->json([
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show(Request $request, Task $task)
    {
        try {
            return response()->json([
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $task->update($request->all());

            return response()->json([
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function destroy(Request $request, Task $task)
    {
        try {
            $task->delete();

            return response()->json([
                'task' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
