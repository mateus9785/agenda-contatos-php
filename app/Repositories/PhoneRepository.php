<?php

namespace App\Repositories;

use App\Models\Phone;
use App\Repositories\PhoneRepositoryInterface;

class PhoneRepository implements PhoneRepositoryInterface
{
    /**
     * Buscar todos os telefones
     *
     * @param int $contact_id
     */

    public function findAll($contact_id)
    {
        return Phone::where('contact_id', $contact_id)->get();
    }

    /**
     * Deletar todos os telefones de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id)
    {
        Phone::where('contact_id', $contact_id)->delete();
    }

    /**
     * Cadastra telefone
     *
     * @param string $name
     * @param int $contact_id
     */

    public function store($name, $contact_id)
    {
        return Phone::create([
            'name' => $name,
            "contact_id" => $contact_id,
        ]);
    }
}
