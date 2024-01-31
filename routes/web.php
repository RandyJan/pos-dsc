<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mopController;
use App\Http\Controllers\pumpController;
use App\Http\Controllers\receiptController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LoginController;

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
    return view('LoginNew');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');



Route::get('/pos',[pumpController::class, 'pump'])->name('pos');
Route::get('/authorizepump',[pumpController::class, 'authorizejson'])->name('authpump');
Route::get('/stoppump',[pumpController::class, 'pumpstop'])->name('stoppump');
Route::get('/mop',[mopController::class, 'mop'] );
Route::post('/payTransaction', [pumpController::class, 'payTransaction'])->name('payTransaction');
Route::post('/voidTransaction', [pumpController::class, 'voidTransaction'])->name('voidTransaction');
Route::post('/voidAllTransactions', [pumpController::class, 'voidAllTransactions'])->name('voidAllTransactions');
Route::post('/getitems', [pumpController::class,'sendTransaction']);
Route::post('/receipt', [receiptController::class,'getReceiptLayout']);
Route::post('/updateTrans', [pumpController::class,'updateTransaction']);
Route::post('/logins',[LoginController::class, 'LoginJson']);
Route::get('/logouts',[LoginController::class, 'LogoutJson']);
Route::post('/receiptItems', [pumpController::class, 'getReceiptItems']);
// ->middleware(['auth']);

Route::get('/transaction', function () {
    return view('transaction');
})->name('transaction');

require __DIR__.'/auth.php';
