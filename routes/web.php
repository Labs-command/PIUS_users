<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewsController;

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
        Route::get('/', [ViewsController::class, 'userPage']);
        Route::get('/moderator', [ViewsController::class, 'moderatorPage']);
        Route::post('/moderator/confirm/{id}', [ViewsController::class, 'reportedTaskConfirm']);
        Route::post('/moderator/reject/{id}', [ViewsController::class, 'reportedTaskReject']);
    }
);
