<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $user = Auth::getUser();
        if ($user->isAdmin()) {
            if (request()->ajax()) {
                return datatables()->of(User::select('*'))
                    ->addColumn('action', 'action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('vue');
        } else {
            return view('vue');
        }
    }

}
