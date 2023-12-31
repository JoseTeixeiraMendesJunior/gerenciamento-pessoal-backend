<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\RecurringTransactionController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TransactionCategoryController;
use App\Http\Controllers\Api\ShoppingListController;

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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::apiResource('tasks', TaskController::class);

    Route::apiResource('recurring-transactions', RecurringTransactionController::class);

    Route::apiResource('transactions', TransactionController::class);

    Route::get('wallet', [TransactionController::class, 'wallet'])->name('wallet');

    Route::apiResource('transaction-categories', TransactionCategoryController::class);

    Route::apiResource('shopping_lists', ShoppingListController::class);

});
