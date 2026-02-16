<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthService {
    public function registerUser(array $data): User {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
        ]);
    }

    public function login(array $loginDetails){
        $user = User::where('email', $loginDetails['email'],)->first();
        if(!$user || !Hash::check($loginDetails['password'], $user->password)){
            return null;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ];
    }
}
