<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $categories = Category::where('user_id', $request->user()->id)->get();

        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $category = Category::with('tasks')
            ->where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, string $id): JsonResponse
    {
        $category = Category::where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $category->update($request->validated());

        return response()->json($category);
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $category = Category::where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $category->delete();

        return response()->json(['message' => 'Categoria deletada.']);
    }
}
