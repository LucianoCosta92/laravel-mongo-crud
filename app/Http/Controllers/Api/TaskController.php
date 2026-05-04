<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $query = Task::where('user_id', $request->user()->id);

        if($request->filled('status')){
            $query->where('status', $request->status);
        }
        if($request->filled('priority')){
            $query->where('priority', $request->priority);
        }
        return response()->json($query->get());
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $task = Task::create($data);

        return response()->json($task, 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $task = Task::where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = Task::where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $task->update($request->validated());

        return response()->json($task);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $task = Task::where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $task->delete();

        return response()->json(['message' => 'Tarefa deletada']);
    }
}
