<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\GroupServiceInterface;
use App\Repositories\GroupRepositoryInterface;

class GroupService implements GroupServiceInterface
{
    /**
     * Cria uma nova intância do service e faz injeção de dependência dos services
     *
     * @param App\Repositories\GroupRepositoryInterface $groupRepository
     * @return void
     */

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Método de listar grupos
     *
     * @param int $per_page
     */

    public function index($per_page = 10)
    {
        $user_id = Auth::user()->id;

        return $this->groupRepository->findAllPaginate($user_id, $per_page);
    }

    /**
     * Método de cadastrar grupo.
     *
     * @param string $name
     * @return object
     */

    public function store($name)
    {
        $user_id = Auth::user()->id;

        return $this->groupRepository->store($user_id, $name);
    }

    /**
     * Método de alterar grupo.
     *
     * @param int $id
     * @param string $name
     * @return object
     */

    public function update($id, $name)
    {
        $user_id = Auth::user()->id;

        $group = $this->groupRepository->findById($id, $user_id);

        if (!$group) {
            return response("Grupo não encontrado", 404);
        }

        return $this->groupRepository->update($group, $name);
    }

    /**
     * Método de deletar grupo
     *
     * @param int $id
     * @return void
     */

    public function destroy($id)
    {
        $user_id = Auth::user()->id;

        $group = $this->groupRepository->findById($id, $user_id);

        if (!$group) {
            return response("Grupo não encontrado", 404);
        }

        $this->groupRepository->delete($group);
    }
}
