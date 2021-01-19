<?php

namespace App\Repositories;

use App\Models\ContactGroup;
use App\Repositories\ContactGroupRepositoryInterface;

class ContactGroupRepository implements ContactGroupRepositoryInterface
{
    public function findAll($contact_id)
    {
        return ContactGroup::where('contact_id', $contact_id)->joinGroup()->get();
    }

    public function deleteByContactId($contact_id)
    {
        ContactGroup::where('contact_id', $contact_id)->delete();
    }

    public function store($user_id, $group_id, $contact_id)
    {
        return ContactGroup::create([
            'user_id' => $user_id,
            "contact_id" => $contact_id,
            "group_id" => $group_id,
        ]);
    }
}
