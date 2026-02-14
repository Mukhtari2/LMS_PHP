<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function updateProfile(User $user, array $data){
        if(!empty($data ['password'])){
            $data['password'] = Hash::make('password');
        } else{
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function changeUserRole(User $user, string $role){
        if(in_array($role, ['student, teacher, admin'])){
            $user->update(['role' => $role]);
            return true;
        }
        return false;
    }
}
