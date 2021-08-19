<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TodoListController extends Controller
{
    public function index()
    {
        $user = Auth::getUser();
        if ($user->isAdmin()) {
            if (request()->ajax()) {
                return datatables()->of(TodoList::select('*')->with('user'))
                    ->editColumn('is_complete', function (TodoList $todo) {
                        return ($todo->is_complete == 1) ? trans('Complete') : trans('Incomplete');
                    })
                    ->addColumn('action', 'action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(TodoList::select('*')->where('user_id', $user->id)->with('user'))
                    ->editColumn('is_complete', function (TodoList $todo) {
                        return ($todo->is_complete == TodoList::STATUS_COMPLETE) ? trans('Complete') : trans('Incomplete');
                    })
                    ->addColumn('action', 'action')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
        }
        return view('todo');
    }

    public function store(TodoListRequest $request)
    {
        $user = Auth::getUser();
        $todo = TodoList::create([
            'body' => $request->body,
            'is_complete' => 0,
            'user_id' => $user->id,
        ]);

        return Response::json($todo);
    }

    public function destroy($id)
    {
        TodoList::where('id', $id)->delete();

        return back();
    }

    public function edit($id)
    {
        $user  = TodoList::findOrFail($id);

        return $user;
    }

    public function update(TodoListRequest $request)
    {
        $todo = TodoList::updateOrCreate(
            [
                'id' => $request->todo_id
            ],
            [
                'body' => $request->body_edit,
                'is_complete' => $request->complete_edit,
            ]
        );

        return $todo;
    }
}
