<?php

namespace App\Http\Services;

use App\Http\Services\GroupServiceInterface;
use App\Http\Repositories\GroupRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GroupService implements GroupServiceInterface
{
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function index($per_page = 10)
    {
        $user_id = Auth::user()->id;

        return $this->groupRepository->findAllPaginate($user_id, $per_page);
    }

    public function store($name)
    {
        $user_id = Auth::user()->id;

        $this->groupRepository->store($user_id, $name);
    }

    public function update($id, $name)
    {
        $user_id = Auth::user()->id;

        $group = $this->groupRepository->findById($id, $user_id);

        if (!$group) {
            return response("Grupo não encontrado", 404);
        }

        return $this->groupRepository->update($group, $name);
    }

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
