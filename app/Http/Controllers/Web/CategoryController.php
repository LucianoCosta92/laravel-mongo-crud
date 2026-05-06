<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->get();

        $categories->each(function($category){
            $category->tasks_count = $category->tasks()->count();
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

        return back()->with('success', 'Categoria excluída.');
    }
}
