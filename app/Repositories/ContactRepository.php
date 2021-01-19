<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Busca contato por id
     *
     * @param int $id
     * @param int $user_id
     */

    public function findById($id, $user_id)
    {
        return Contact::findOne($id, $user_id);
    }

    /**
     * Busca todos os contatos
     *
     * @param int $user_id
     */

    public function findAll($user_id)
    {
        return Contact::where('user_id', $user_id)->orderBy('name', 'ASC')->get();
    }

    /**
     * Busca todos os contatos paginados
     *
     * @param int $user_id
     * @param int $group_id
     * @param string $search
     * @param int $per_page
     */

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

    /**
     * Cadastro de contatos
     *
     * @param int $user_id
     * @param string $name
     * @param string $name_file
     * @param boolean $is_user_contact
     */

    public function store($user_id, $name, $name_file = null, $is_user_contact = false)
    {
        return Contact::create([
            'user_id' => $user_id,
            "name" => $name,
            "is_user_contact" => $is_user_contact,
            "name_file" => $name_file
        ]);
    }

    /**
     * Alteração de contatos
     *
     * @param object $contact
     * @param string $name
     * @param string $name_file
     */

    public function update($contact, $name, $name_file)
    {
        $contact->update([
            "name" => $name,
            "name_file" => $name_file,
        ]);

        return $contact;
    }

    /**
     * Deleta contato
     *
     * @param object $contact
     */

    public function delete($contact)
    {
        $contact->delete();
    }
}
