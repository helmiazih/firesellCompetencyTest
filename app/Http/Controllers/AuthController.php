<?php
namespace App\Http\Controllers;
 
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
 
class AuthController extends Controller
{   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function show_signup_form()
    {
        if (View::exists('auth.register')) {
            
            return view('auth.register');
 
        }
    }
 
    public function process_signup(Request $request)
    {
        $this->validate($request, [ 
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
 
        $user = new User;
        $user->username = $request->username;
        $user->email = strtolower($request->email);
        $user->password = $request->password;
        $user->save();
 
        return response()->json(
            [
                'success' => true,
                'message' => 'Registration is completed'
            ]
        );
 
    }
 
}