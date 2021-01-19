<?php

namespace App\Repositories;

interface PhoneRepositoryInterface
{
    /**
     * Buscar todos os telefones
     *
     * @param int $contact_id
     */

    public function findAll($contact_id);

    /**
     * Deletar todos os telefones de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id);

    /**
     * Cadastra telefone
     *
     * @param string $name
     * @param int $contact_id
     */

    public function store($name, $contact_id);
}
