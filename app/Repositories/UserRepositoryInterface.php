<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * Cadastra usuário
     *
     * @param string $email
     * @param string $password
     */

    public function store($email, $password);
}
