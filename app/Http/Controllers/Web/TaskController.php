<?php

namespace App\Http\Controllers\Web;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        return view('tasks.index', [
            'tasks' => $query->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('tasks.form', [
            'categories' => Category::where('user_id', auth()->id())->get(),
        ]);
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

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(string $id)
    {
        $task = Task::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('tasks.form', [
            'task'       => $task,
            'categories' => Category::where('user_id', auth()->id())->get(),
        ]);
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

        return back()->with('success', 'Tarefa concluída!');
    }

    public function destroy(string $id)
    {
        Task::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail()
            ->delete();

        return back()->with('success', 'Tarefa excluída.');
    }
}
