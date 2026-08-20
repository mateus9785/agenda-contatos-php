<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Cadastra usuário
     *
     * @param  string  $email
     * @param  string  $password
     */
    public function store($email, $password)
    {
        return User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
