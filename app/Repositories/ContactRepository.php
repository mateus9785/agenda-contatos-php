<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    public function findById($id, $user_id)
    {

        return Contact::findOne($id, $user_id);
    }

    public function findAll($user_id)
    {
        return Contact::where('user_id', $user_id)->orderBy('name', 'ASC')->get();
    }

    public function findAllPaginate($user_id, $group_id, $search, $per_page)
    {

        $query = Contact::where('contacts.user_id', $user_id);
        if ($search) {
            $query->where('contacts.name', 'like', '%' . $search . '%');
        }

        if ($group_id) {
            $query->join('contact_groups', function ($join) use ($group_id) {
                $join->on('contacts.id', '=', 'contact_groups.contact_id')
                    ->where('contact_groups.group_id', $group_id);
            });
        }

        return $query->orderBy('name', 'ASC')->paginate($per_page);
    }

    public function store($user_id, $name, $name_file = null, $is_user_contact = false)
    {

        return Contact::create([
            'user_id' => $user_id,
            "name" => $name,
            "is_user_contact" => $is_user_contact,
            "name_file" => $name_file
        ]);
    }

    public function update($contact, $name, $name_file)
    {

        $contact->update([
            "name" => $name,
            "name_file" => $name_file,
        ]);

        return $contact;
    }

    public function delete($contact)
    {
        $contact->delete();
    }
}
