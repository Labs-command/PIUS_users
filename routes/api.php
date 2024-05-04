<?php

use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserRolesApiController;
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
//Route::middleware(['auth.api'])->prefix('/')->group(
    function () {
        Route::get('/user', [UserApiController::class, 'list']);
        Route::post('/user', [UserApiController::class, 'create']);
        Route::put('/user', [UserApiController::class, 'update']);
        Route::delete('/user', [UserApiController::class, 'delete']);

        Route::get('/roles', [UserRolesApiController::class, 'list']);
        Route::put('/roles', [UserRolesApiController::class, 'set']);
        Route::post('/roles', [UserRolesApiController::class, 'add']);
        Route::delete('/roles', [UserRolesApiController::class, 'remove']);
    }
);
