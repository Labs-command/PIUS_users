<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRolesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/user', [UserController::class, 'list']);
Route::post('/user', [UserController::class, 'create']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user', [UserController::class, 'delete']);

Route::get('/user/roles', [UserRolesController::class, 'list']);
Route::put('/user/roles', [UserRolesController::class, 'set']);
Route::post('/user/roles', [UserRolesController::class, 'add']);
Route::delete('/user/roles', [UserRolesController::class, 'remove']);
