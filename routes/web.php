<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mopController;
use App\Http\Controllers\pumpController;
use App\Http\Controllers\receiptController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    return view('auth/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');



Route::get('/pos',[pumpController::class, 'pump'])->middleware(['auth'])->name('pos');
Route::get('/authorizepump',[pumpController::class, 'authorizejson'])->middleware(['auth'])->name('authpump');
Route::get('/stoppump',[pumpController::class, 'pumpstop'])->middleware(['auth'])->name('stoppump');
Route::get('/mop',[mopController::class, 'mop'] );
Route::post('/payTransaction', [pumpController::class, 'payTransaction'])->middleware(['auth'])->name('payTransaction');
Route::post('/voidTransaction', [pumpController::class, 'voidTransaction'])->middleware(['auth'])->name('voidTransaction');
Route::post('/voidAllTransactions', [pumpController::class, 'voidAllTransactions'])->middleware(['auth'])->name('voidAllTransactions');
Route::post('/getitems', [pumpController::class,'sendTransaction']);
Route::post('/receipt', [receiptController::class,'getReceiptLayout']);
Route::post('/updateTrans', [pumpController::class,'updateTransaction']);
// ->middleware(['auth']);

Route::get('/transaction', function () {
    return view('transaction');
})->name('transaction');

require __DIR__.'/auth.php';
