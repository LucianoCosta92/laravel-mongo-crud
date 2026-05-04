<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data             = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    public function show(Request $request): JsonResponse
    {
        $user = User::with(['tasks', 'categories'])
            ->findOrFail($request->user()->id);

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user()->id);
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password'], $data['password_confirmation']);
        }

        $user->update($data);

        return response()->json($user);
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->user()->id);

        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Conta removida com sucesso.']);
    }
}
