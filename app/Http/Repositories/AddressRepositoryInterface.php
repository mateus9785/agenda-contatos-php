<?php

namespace App\Http\Repositories;

interface AddressRepositoryInterface
{
    public function findAll($contact_id);

    public function deleteByContactId($contact_id);

    public function store($address, $contact_id);
}