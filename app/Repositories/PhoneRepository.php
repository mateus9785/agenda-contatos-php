<?php

namespace App\Repositories;

use App\Models\Phone;
use App\Repositories\PhoneRepositoryInterface;

class PhoneRepository implements PhoneRepositoryInterface
{
    public function findAll($contact_id)
    {
        return Phone::where('contact_id', $contact_id)->get();
    }

    public function deleteByContactId($contact_id)
    {
        Phone::where('contact_id', $contact_id)->delete();
    }

    public function store($name, $contact_id)
    {
        return Phone::create([
            'name' => $name,
            "contact_id" => $contact_id,
        ]);
    }
}
