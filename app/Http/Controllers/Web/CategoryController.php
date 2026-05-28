<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    private const TTL = 300;

    public function index()
    {
        $userId = auth()->id();

        $categories = Cache::remember("categories:list:{$userId}", self::TTL, function () use ($userId) {
            $categories = Category::where('user_id', $userId)->get();

            $categories->each(function ($category) {
                $category->tasks_count = $category->tasks()->count();
            });

            return $categories;
        });

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|regex:/^#([A-Fa-f0-9]{6})$/',
        ]);

        $data['user_id'] = auth()->id();

        Category::create($data);

        $this->clearCache(auth()->id());

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(string $id)
    {
        $category = Category::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('categories.form', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|regex:/^#([A-Fa-f0-9]{6})$/',
        ]);

        $category->update($data);

        $this->clearCache(auth()->id());

        return redirect()->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $category = Category::where('_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($category->tasks()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma categoria com tarefas vinculadas.');
        }

        $category->delete();

        $this->clearCache(auth()->id());

        return back()->with('success', 'Categoria excluída.');
    }

    public static function clearCache(string $userId): void
    {
        Cache::forget("categories:list:{$userId}");
    }
}
