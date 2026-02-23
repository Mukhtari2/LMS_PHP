<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


class AuthService {
    public function registerUser(array $data): User {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        event(new Registered($user));

        return $user;
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
