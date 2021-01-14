<?php

namespace App\Http\Repositories;

interface PhoneRepositoryInterface
{
    public function findAll($contact_id);

    public function deleteByContactId($contact_id);

    public function store($name, $contact_id);
}