<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\IndexGroupRequest;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Services\GroupServiceInterface;

class GroupController extends Controller
{
    /**
     * Cria uma nova intância do controller e faz injeção de dependência dos services
     *
     * @param App\Services\GroupServiceInterface $groupService
     * @return void
     */

    public function __construct(GroupServiceInterface $groupService)
    {
        $this->middleware('auth');
        $this->groupService = $groupService;
    }

    /**
     * Método de mostrar vários grupos.
     *
     * @param App\Http\Requests\Contact\IndexGroupRequest $request
     * @return Symfony\Component\HttpFoundation\Response
     */

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

    /**
     * Método de cadastrar grupos.
     *
     * @param App\Http\Requests\Contact\StoreGroupRequest $request
     * @return Symfony\Component\HttpFoundation\Response
     */

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

    /**
     * Método de alterar grupos.
     *
     * @param App\Http\Requests\Contact\UpdateGroupRequest $request
     * @param int $id
     * @return Symfony\Component\HttpFoundation\Response
     */

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

    /**
     * Método de detruir grupos.
     *
     * @param int $id
     * @return Symfony\Component\HttpFoundation\Response
     */

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
