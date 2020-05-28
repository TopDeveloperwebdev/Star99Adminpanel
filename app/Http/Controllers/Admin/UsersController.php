<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use App\Player;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        $users = Player::all();

        return view('admin.users.index', compact('users'));
    }
    public function filterUsers(Request $request)
    {
        $filterKey = $request->all();
        $sdate = date('yy-m-d h:m:s', strtotime($filterKey['sDate']));
        $edate = date('yy-m-d h:m:s', strtotime($filterKey['eDate']));
        $users =  DB::select("SELECT * FROM `players` WHERE `created_at` > '$sdate' And `created_at` <= '$edate' ORDER BY `created_at` ASC");

        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        $user = Player::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, Player $user)
    {
        $user->update($request->all());

        return redirect()->route('admin.users.index');
    }
    public function updateUsers(Request $request, Player $user)
    {
        $all = $request->all();
        $users = $all['users'];
        foreach ($users  as $key => $row) {
            DB::insert("UPDATE `players` SET `phone_verified_at` = NULL, `credits` = '$row[credits]', `max_bet` = '$row[max_bet]', `max_day` = '$row[max_day]'  WHERE `players`.`phone` = '$row[phone]'");
        }
         return redirect()->route('admin.users.index');
    }

    public function editUsers(UpdateUserRequest $request, Player $user)
    {
        $user->update($request->all());
        return redirect()->route('admin.users.index');
    }
    public function show($id)
    {
        $user = Player::find($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy(Player $user)
    {
        $user->status = !($user->status);
        $user->save();
        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
