<?php

namespace App\Repositories;

interface GroupRepositoryInterface
{
    /**
     * Buscar grupo por id
     *
     * @param int $id
     * @param int $user_id
     */

    public function findById($id, $user_id);

    /**
     * Buscar todos os grupos
     *
     * @param int $user_id
     */

    public function findAll($user_id);

    /**
     * Buscar todos os grupos paginado
     *
     * @param int $user_id
     * @param int $per_page
     */

    public function findAllPaginate($user_id, $per_page);

    /**
     * Cadastra grupo
     *
     * @param int $user_id
     * @param string $name
     */

    public function store($user_id, $name);

    /**
     * Alterar grupo
     *
     * @param string $name
     * @param object $group
     */

    public function update($group, $name);

    /**
     * deletar grupo
     *
     * @param object $group
     */

    public function delete($group);
}