<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser($name, $email, $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    public function updateUserProfile($id, $name, $email, $password = null)
    {
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;

        if ($password) {
            $user->password = Hash::make($password);
        }

        $user->save();

        return $user;
    }
}