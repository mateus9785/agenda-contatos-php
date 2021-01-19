<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    /**
     * Busca todos os endereços
     *
     * @param int $contact_id
     */

    public function findAll($contact_id)
    {
        return Address::where('contact_id', $contact_id)->get();
    }

    /**
     * Deleta endereços de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id)
    {
        Address::where('contact_id', $contact_id)->delete();
    }

    /**
     * Cadastra endereço
     *
     * @param array $address
     * @param int $contact_id
     */

    public function store($address, $contact_id)
    {
        return Address::register($address, $contact_id);
    }
}
