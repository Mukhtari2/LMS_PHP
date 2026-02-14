<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Container\Attributes\Auth;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function edit(){
        return view('profile.edit', ['user' => Auth::user()]);
    }


    public function update(Request $request){
        $user = Auth::user();

        $validted = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $this->userService->updateProfile($user, $validted);

        return back()->with('status', 'Profile updated successfully!');
    }

}
