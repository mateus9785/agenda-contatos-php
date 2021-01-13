<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $per_page = $request->per_page ?? 10;
        $groups = Group::where('user_id', $user_id)
            ->orderBy('name','ASC')
            ->paginate($per_page);

        return view('group', ['groups' => $groups]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $group = Group::create([
            'user_id' => $user_id,
            "name" => $request->name
        ]);

        return response($group, 200);
    } 

    public function update(Request $request, int $id)
    {
        $user_id = Auth::user()->id;
        $group = Group::findOne($id, $user_id);

        if(!$group)
            return response("Grupo não encontrado", 404);

        $group->update([
            "name" => $request->name
        ]);

        return response($group, 200);
    }

    public function destroy(int $id)
    {
        $user_id = Auth::user()->id;
        $group = Group::findOne($id, $user_id);

        if(!$group)
            return response("Grupo não encontrado", 404);

        $group->delete();

        return response([], 200);
    }
}

