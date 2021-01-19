<?php

namespace App\Repositories;

interface ContactGroupRepositoryInterface
{
    /**
     * busca todos os grupos de contatos
     *
     * @param int $contact_id
     */

    public function findAll($contact_id);

    /**
     * deletar todos os grupos de contatos de um contato
     *
     * @param int $contact_id
     */

    public function deleteByContactId($contact_id);

    /**
     * cadastrar grupo de contato
     *
     * @param int $user_id
     * @param int $group_id
     * @param int $contact_id
     */

    public function store($user_id, $group_id, $contact_id);
}
