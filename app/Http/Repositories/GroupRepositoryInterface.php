<?php

namespace App\Http\Repositories;

interface GroupRepositoryInterface
{

    public function findById($id, $user_id);

    public function findAll($user_id);

    public function findAllPaginate($user_id, $per_page);

    public function store($user_id, $name);

    public function update($group, $name);

    public function delete($group);
}