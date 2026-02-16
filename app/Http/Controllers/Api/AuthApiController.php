<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthApiController extends Controller {

    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService= $authService;
    }

    public function createUser(Request $request): JsonResponse{
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:student,teacher,admin'
        ]);

        $user = $this->authService->registerUser($data);
        return response()->json([
            'message' => "user created successfully!",
            'user' => $user
        ], 201);
    }

    public function login(Request $request): JsonResponse {
        $loginDetails = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $result = $this->authService->login($loginDetails);

        if(!$result){
            return response()->json(['message' => 'Invalid login details'], 401);
        }
        return response()->json($result, 201);
    }
}
