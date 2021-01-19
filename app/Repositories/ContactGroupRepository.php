<?php

namespace App\Repositories;

use App\Models\ContactGroup;
use App\Repositories\ContactGroupRepositoryInterface;

class ContactGroupRepository implements ContactGroupRepositoryInterface
{
    /**
     * busca todos os grupos de contatos
     *
     * @param int $contact_id
     */

    public function findAll($contact_id)
    {
        return ContactGroup::where('contact_id', $contact_id)->joinGroup()->get();
    }

    /**
     * deletar todos os grupos de contatos de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id)
    {
        ContactGroup::where('contact_id', $contact_id)->delete();
    }

    /**
     * cadastrar grupo de contato
     *
     * @param int $user_id
     * @param int $group_id
     * @param int $contact_id
     */

    public function store($user_id, $group_id, $contact_id)
    {
        return ContactGroup::create([
            'user_id' => $user_id,
            "contact_id" => $contact_id,
            "group_id" => $group_id,
        ]);
    }
}
