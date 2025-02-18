<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoItemController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/hone', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Auth::routes();


Route::get('/', [TodoItemController::class,'index'])->name('showTodosPage');
Route::get('/todos', [TodoItemController::class,'todos'])->name('loadTodos');
Route::post('/todos', [TodoItemController::class,'store'])->name('storeTodos');
Route::put('/todos/{todoItem}', [TodoItemController::class,'update'])->name('updateTodo');
Route::delete('/todos/{todoItem}', [TodoItemController::class,'destroy'])->name('deleteTodo');
