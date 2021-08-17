<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TodoListController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(TodoList::select('*'))
                ->addColumn('name', function (TodoList $todo) {
                    return empty($todo->user->name) ? $todo->user_id : $todo->user->name;
                })
                ->editColumn('is_complete', function(TodoList $todo) {
                    return ($todo->is_complete == 1) ? trans('Complete'): trans('Incomplete');
                  })
                ->addColumn('action', 'action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $todo = TodoList::where('id', 1)->first();
        return view('todo', compact('todo'));
    }

    public function store(Request $request)
    {
        $user = Auth::getUser();
        TodoList::create([
            'body' => $request->body,
            'is_complete' => 0,
            'user_id' => $user->id,
        ]);

        return back();
    }

    public function destroy($id)
    {
        $product = TodoList::where('id', $id)->delete();

        return back();
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = TodoList::where($where)->first();

        return Response::json($user);
    }

    public function update(Request $request)
    {
        TodoList::updateOrCreate(
            [
                'id' => $request->todo_id
            ],
            [
                'body' => $request->body_edit,
                'is_complete' => $request->complete_edit,
            ]
        );

        return back();
    }
}
