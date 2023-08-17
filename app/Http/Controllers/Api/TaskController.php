<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tasks = $request->user()->tasks()
                ->when(isset($request->search), function ($query) use ($request) {
                    $date = Carbon::parse($request->search)->format('Y-m-d');
                    $query->where('due_date', $date);
                })
                ->get();

            return TaskResource::collection($tasks);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function store(TaskRequest $request)
    {
        try {

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'due_date' => Carbon::parse($request->due_date)->format('Y-m-d'),
                'priority' => $request->priority,
                'status' => $request->status ?? 'todo',
                'type' => $request->type,
            ];

            $task = $request->user()->tasks()->create($data);

            return TaskResource::make($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show(Request $request, Task $task)
    {
        try {
            return TaskResource::make($task);
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

            return TaskResource::make($task);
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
