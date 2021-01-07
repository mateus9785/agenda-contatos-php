<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = json_encode(Group::paginate(10));

        return view('group.index', ['response' => json_decode($groups)]);
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());
        return response($group, 200);
    } 

    public function update(Request $request, Group $group)
    {
        $group->update($request->all());

        return response($group, 200);
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return response([], 200);
    }
}
