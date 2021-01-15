<?php

namespace App\Http\Repositories;

use App\Models\Address;
use App\Http\Repositories\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    public function findAll($contact_id)
    {
        return Address::where('contact_id', $contact_id)->get();
    }

    public function deleteByContactId($contact_id)
    {
        Address::where('contact_id', $contact_id)->delete();
    }

    public function store($address, $contact_id)
    {
        return Address::register($address, $contact_id);
    }
}
