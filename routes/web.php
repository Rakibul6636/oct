<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

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



Auth::routes();
Route::redirect('/users', '/register');
Route::redirect('/home', '/');


Route::post('/deposit', [App\Http\Controllers\TransactionController::class, 'deposit'])->name('deposit');
Route::get('/deposit', [App\Http\Controllers\TransactionController::class, 'showDeposits'])->name('showDeposits');
Route::get('/depositForm', [App\Http\Controllers\TransactionController::class, 'showDepositForm'])->name('depositForm');

Route::get('/withdrawalForm', [App\Http\Controllers\TransactionController::class, 'showWithdrawForm'])->name('showWithdrawForm');
Route::post('/withdrawal', [App\Http\Controllers\TransactionController::class, 'withdraw'])->name('withdraw');
Route::get('/withdrawal', [App\Http\Controllers\TransactionController::class, 'showWithdrawals'])->name('showWithdrawals');

Route::get('/', [App\Http\Controllers\TransactionController::class, 'showTransactions'])->name('showTransactions');

