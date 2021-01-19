<?php

namespace App\Repositories;

interface PhoneRepositoryInterface
{
    public function findAll($contact_id);

    public function deleteByContactId($contact_id);

    public function store($name, $contact_id);
}
