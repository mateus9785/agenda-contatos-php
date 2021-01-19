<?php

namespace App\Repositories;

interface ContactGroupRepositoryInterface
{
    public function findAll($contact_id);

    public function deleteByContactId($contact_id);

    public function store($user_id, $group_id, $contact_id);
}
