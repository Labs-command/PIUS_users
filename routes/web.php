<?php

use App\Http\Controllers\ModeratorsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('users')->group(
//Route::middleware(['auth.web'])->prefix('users')->group(
    function () {
        Route::get('/', [UsersController::class, 'userPage'])->name('users.page');
        Route::get('/create', [UsersController::class, 'createTaskPage'])->name('users.tasks.create.page');
        Route::post('/create', [UsersController::class, 'createTask'])->name('users.tasks.create');

        Route::get('/moderator', [ModeratorsController::class, 'moderatorPage'])->name('moderators.page');
        Route::post('/moderator/confirm/{id?}', [ModeratorsController::class, 'reportedTaskConfirm'])->name('moderators.tasks.confirm');
        Route::post('/moderator/reject/{id?}', [ModeratorsController::class, 'reportedTaskReject'])->name('moderators.tasks.reject');
    }
);
