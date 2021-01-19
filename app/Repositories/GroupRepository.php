<?php

namespace App\Repositories;

use App\Models\Group;
use App\Repositories\GroupRepositoryInterface;

class GroupRepository implements GroupRepositoryInterface
{
    /**
     * Buscar grupo por id
     *
     * @param int $id
     * @param int $user_id
     */

    public function findById($id, $user_id)
    {
        return Group::findOne($id, $user_id);
    }

    /**
     * Buscar todos os grupos
     *
     * @param int $user_id
     */

    public function findAll($user_id)
    {
        return Group::where('user_id', $user_id)->orderBy('name', 'ASC')->get();
    }

    /**
     * Buscar todos os grupos paginado
     *
     * @param int $user_id
     * @param int $per_page
     */

    public function findAllPaginate($user_id, $per_page)
    {

        return Group::where('user_id', $user_id)
            ->orderBy('name', 'ASC')
            ->paginate($per_page);
    }

    /**
     * Cadastra grupo
     *
     * @param int $user_id
     * @param string $name
     */

    public function store($user_id, $name)
    {

        return Group::create([
            'user_id' => $user_id,
            "name" => $name,
        ]);
    }

    /**
     * Alterar grupo
     *
     * @param string $name
     * @param object $group
     */

    public function update($group, $name)
    {

        $group->update([
            "name" => $name,
        ]);

        return $group;
    }

    /**
     * deletar grupo
     *
     * @param object $group
     */

    public function delete($group)
    {
        $group->delete();
    }
}
