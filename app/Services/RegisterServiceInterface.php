<?php

namespace App\Services;

interface RegisterServiceInterface
{
    public function create($name, $email, $password);
}
