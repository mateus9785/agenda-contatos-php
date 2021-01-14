<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\Group\IndexGroupRequest;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Services\GroupServiceInterface;

class GroupController extends Controller
{

    public function __construct(GroupServiceInterface $groupService)
    {
        $this->middleware('auth');
        $this->groupService = $groupService;
    }

    public function index(IndexGroupRequest $request)
    {
        try {
            $request->validated();

            $groups = $this->groupService->index($request->per_page);

            return view('group', ['groups' => $groups]);
        } catch (\Throwable $exception) {
            return response("Ocorreu um erro ao realizar a opereção", 500);
        }
    }

    public function store(StoreGroupRequest $request)
    {
        try {
            $request->validated();

            $group = $this->groupService->store($request->name);

            return response($group, 200);
        } catch (\Throwable $exception) {
            return response("Ocorreu um erro ao realizar a opereção", 500);
        }
    } 

    public function update(UpdateGroupRequest $request, int $id)
    {
        try {
            $request->validated();

            $group = $this->groupService->update($id, $request->name);

            return response($group, 200);
        } catch (\Throwable $exception) {
            return response("Ocorreu um erro ao realizar a opereção", 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->groupService->destroy($id);

            return response([], 200);

        } catch (\Throwable $exception) {
            return response("Ocorreu um erro ao realizar a opereção", 500);
        }
    }
}

