<?php

namespace App\Http\Controllers\Web;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    private const TTL = 300;

    public function index(Request $request)
    {
        $userId   = auth()->id();
        $status   = $request->input('status', '');
        $priority = $request->input('priority', '');

        $cacheKey = "tasks:list:{$userId}:status={$status}:priority={$priority}";

        $tasks = Cache::tags(["user:{$userId}", "tasks"])->remember($cacheKey, self::TTL, function () use ($userId, $status, $priority) {
            $query = Task::where('user_id', $userId);
            if ($status)   $query->where('status', $status);
            if ($priority) $query->where('priority', $priority);
            return $query->latest()->get();
        });

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $userId = auth()->id();

        $categories = Cache::remember("categories:list:{$userId}", self::TTL, function () use ($userId) {
            return Category::where('user_id', $userId)->get();
        });

        return view('tasks.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status'      => 'required|string',
            'priority'    => 'required|string',
            'due_date'    => 'nullable|date',
            'category_id' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();

        Task::create($data);

        $this->clearCache(auth()->id());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(string $id)
    {
        $userId = auth()->id();

        $task = Task::where('_id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $categories = Cache::remember("categories:list:{$userId}", self::TTL, function () use ($userId) {
            return Category::where('user_id', $userId)->get();
        });

        return view('tasks.form', compact('task', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $task = Task::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status'      => 'required|string',
            'priority'    => 'required|string',
            'due_date'    => 'nullable|date',
            'category_id' => 'nullable|string',
        ]);

        $task->update($data);

        $this->clearCache(auth()->id());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function complete(string $id)
    {
        $task = Task::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $task->update([
            'status'       => TaskStatus::COMPLETED,
            'completed_at' => now(),
        ]);

        $this->clearCache(auth()->id());

        return back()->with('success', 'Tarefa concluída!');
    }

    public function destroy(string $id)
    {
        Task::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail()
            ->delete();

        $this->clearCache(auth()->id());

        return back()->with('success', 'Tarefa excluída.');
    }

    private function clearCache(string $userId): void
    {
        Cache::tags(["user:{$userId}", "tasks"])->flush();
        DashboardController::clearCache($userId);
    }
}
