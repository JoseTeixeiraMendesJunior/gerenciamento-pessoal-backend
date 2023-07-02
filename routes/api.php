<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;

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

Route::group(['prefix' => 'task'], function () {
    Route::get('', [TaskController::class, 'index'])->name('task.index');
    Route::post('', [TaskController::class, 'store'])->name('task.store');
    Route::get('{task}', [TaskController::class, 'show'])->name('task.show');
    Route::put('{task}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('{task}', [TaskController::class, 'destroy'])->name('task.destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
