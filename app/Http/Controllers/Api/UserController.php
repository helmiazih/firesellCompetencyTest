<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            abort(401, 'These credentials do not match our records.');
        }

        if (Hash::check($request->password, $user->password)) {

            $token = $user->createToken('token')->accessToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        }

        abort(401, 'These credentials do not match our records.');
    }

    public function todoList(){
        
        $user = Auth::user();
        
        $todo = TodoList::where('user_id', $user->id)->get();

        return $todo;
    }
}
