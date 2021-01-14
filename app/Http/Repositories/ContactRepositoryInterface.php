<?php

namespace App\Http\Repositories;

interface ContactRepositoryInterface
{

    public function findById($id, $user_id);

    public function findAll($user_id);

    public function findAllPaginate($user_id, $group_id, $search, $per_page);

    public function store($user_id, $name, $name_file = null, $is_user_contact = false);

    public function update($contact, $name, $name_file);

    public function delete($contact);
}