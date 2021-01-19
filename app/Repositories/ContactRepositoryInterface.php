<?php

namespace App\Repositories;

interface ContactRepositoryInterface
{
    /**
     * Busca contato por id
     *
     * @param int $id
     * @param int $user_id
     */

    public function findById($id, $user_id);

    /**
     * Busca todos os contatos
     *
     * @param int $user_id
     */

    public function findAll($user_id);

    /**
     * Busca todos os contatos paginados
     *
     * @param int $user_id
     * @param int $group_id
     * @param string $search
     * @param int $per_page
     */

    public function findAllPaginate($user_id, $group_id, $search, $per_page);

    /**
     * Cadastro de contatos
     *
     * @param int $user_id
     * @param string $name
     * @param string $name_file
     * @param boolean $is_user_contact
     */

    public function store($user_id, $name, $name_file = null, $is_user_contact = false);

    /**
     * Alteração de contatos
     *
     * @param object $contact
     * @param string $name
     * @param string $name_file
     */

    public function update($contact, $name, $name_file);

    /**
     * Deleta contato
     *
     * @param object $contact
     */

    public function delete($contact);
}
