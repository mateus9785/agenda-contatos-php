<?php

namespace App\Repositories;

interface AddressRepositoryInterface
{
    /**
     * Busca todos os endereços
     *
     * @param int $contact_id
     */
    public function findAll($contact_id);

    /**
     * Deleta endereços de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id);

    /**
     * Cadastra endereço
     *
     * @param array $address
     * @param int $contact_id
     */

    public function store($address, $contact_id);
}
