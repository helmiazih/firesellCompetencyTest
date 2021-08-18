<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(UserRegisterRequest $request)
    {
        $user = User::updateOrCreate(
            [
                'id' => $request->user_id,
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]
        );

        return $user;
    }

    public function deleteUser($id)
    {

        $user = User::where('id', $id)->first();

        $user->delete();

        return back();
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = User::where($where)->first();

        return Response::json($user);
    }
}
