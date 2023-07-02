<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->with('subTasks')->get();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $task = $request->user()->tasks()->create($request->all());

        return response()->json([
            'task' => $task,
        ]);
    }

    public function show(Request $request, Task $task)
    {
        return response()->json([
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return response()->json([
            'task' => $task,
        ]);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        return response()->json([
            'task' => $task,
        ]);
    }
}
