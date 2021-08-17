<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //User 
    Route::post('/add-user', [UserController::class, 'index'])->name('addUser');
    Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/edit-user/{id}',[UserController::class, 'edit']);

    //Todo-List
    Route::get('/todo', [TodoListController::class, 'index'])->name('todoList');
    Route::get('/todo-list/{id}/edit',[TodoListController::class, 'edit']);
    Route::post('/todo-list/update', [TodoListController::class, 'update']);
    Route::post('/todo-list/store', [TodoListController::class, 'store']);
    Route::get('/todo-list/delete/{id}',[TodoListController::class, 'destroy']);

});


