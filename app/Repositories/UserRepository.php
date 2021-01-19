<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store($email, $password)
    {
        return User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
