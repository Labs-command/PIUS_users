<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRolesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/')->group(
    function () {
        Route::get('/', [UserController::class, 'list']);
        Route::post('/', [UserController::class, 'create']);
        Route::put('/', [UserController::class, 'update']);
        Route::delete('/', [UserController::class, 'delete']);

        Route::get('/roles', [UserRolesController::class, 'list']);
        Route::put('/roles', [UserRolesController::class, 'set']);
        Route::post('/roles', [UserRolesController::class, 'add']);
        Route::delete('/roles', [UserRolesController::class, 'remove']);
    }
);
