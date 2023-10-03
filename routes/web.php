<?php

use Illuminate\Support\Facades\Auth;
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

Route::view('/', 'welcome');
Auth::routes();

/* authenticated route */
Route::middleware(['auth'])->group(function () {

    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::get('customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer');
    Route::get('material', [App\Http\Controllers\MaterialController::class, 'index'])->name('material');

    Route::get('invoice/print/{invoice}', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoice.print');
    Route::get('invoice/send/{invoice}', [App\Http\Controllers\InvoiceController::class, 'send'])->name('invoice.send');
    Route::resource('invoice', App\Http\Controllers\InvoiceController::class);
});
