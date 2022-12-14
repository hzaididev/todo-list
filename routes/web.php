<?php

  use Illuminate\Support\Facades\Redirect;
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
  return Redirect::to( '/todos');
});

Route::get('/todos/analytics',['App\Http\Controllers\ToDoController', 'analytics'])->name('todos.analytics');

Route::resource('/todos', 'App\Http\Controllers\ToDoController');