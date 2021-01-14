<?php

namespace App\Http\Services;

interface RegisterServiceInterface
{
    public function create($name, $email, $password);
}
