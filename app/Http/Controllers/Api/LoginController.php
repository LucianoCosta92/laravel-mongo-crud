<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse{

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            $user = Auth::user();

            $token = $user->createToken('api-token')->plainTextToken;

            // request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorretos!',
            ], 401);
        }
    }

    public function logout(User $user): JsonResponse{
        try {
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => $user->name . ' deslogado com sucesso',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deslogar!',
            ], 401);
        }
    }
}
