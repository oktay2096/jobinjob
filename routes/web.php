<?php

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


Route::get('/login', function () {
    return view('Login');
})->name('login');

Route::get('/task-listies', function () {
    return view('Dashboard');
})->name('dashboard')->middleware('Login');

Route::get('/dashborad', function () {
    if(Session::get('Login')->role == 1)
    {
        return view('Dashboard');
    }
    else
    {
        return view('User-Dashboard');
    }
    
})->name('dashboard')->middleware('Login');



Route::get('/hafta', function () {
    echo date("w");
})->name('dashboard')->middleware('Login');

Route::get('/user-listies', function () {
    return view('User-List');
})->name('user.listes')->middleware('Login');


Route::post('taskdeletes', [App\Http\Controllers\AdminController::class, 'taskdelete'])->name('task.delete')->middleware('Login');
Route::post('user-delete', [App\Http\Controllers\AdminController::class, 'userdelete'])->name('user.delete')->middleware('Login');

Route::post('login-control', [App\Http\Controllers\AuthController::class, 'login'])->name('login.control');
Route::post('task-add', [App\Http\Controllers\AdminController::class, 'taskadd'])->name('task.add')->middleware('Login');
Route::post('user-add', [App\Http\Controllers\AdminController::class, 'useradd'])->name('user.add')->middleware('Login');
Route::get('user-list', [App\Http\Controllers\AdminController::class, 'userlist'])->name('user.list')->middleware('Login');
Route::get('task-list', [App\Http\Controllers\AdminController::class, 'tasklist'])->name('task.list')->middleware('Login');
Route::get('logaut', [App\Http\Controllers\AuthController::class, 'logaut'])->name('logaut')->middleware('Login');
Route::get('/information-list', [App\Http\Controllers\AdminController::class, 'info'])->name('info')->middleware('Login');