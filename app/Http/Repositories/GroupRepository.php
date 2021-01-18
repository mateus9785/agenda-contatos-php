<?php

namespace App\Http\Repositories;

use App\Models\Group;
use App\Http\Repositories\GroupRepositoryInterface;

class GroupRepository implements GroupRepositoryInterface
{
    public function findById($id, $user_id)
    {

        return Group::findOne($id, $user_id);
    }

    public function findAll($user_id)
    {
        return Group::where('user_id', $user_id)->orderBy('name', 'ASC')->get();
    }

    public function findAllPaginate($user_id, $per_page)
    {

        return Group::where('user_id', $user_id)
            ->orderBy('name', 'ASC')
            ->paginate($per_page);
    }

    public function store($user_id, $name)
    {

        return Group::create([
            'user_id' => $user_id,
            "name" => $name,
        ]);
    }

    public function update($group, $name)
    {

        $group->update([
            "name" => $name,
        ]);

        return $group;
    }

    public function delete($group)
    {
        $group->delete();
    }
}
