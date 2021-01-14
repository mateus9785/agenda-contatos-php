<?php

namespace App\Http\Repositories;

interface UserRepositoryInterface
{
    public function store($email, $password);
}