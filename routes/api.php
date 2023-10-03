<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/storeMaterial', [App\Http\Controllers\APIs\InvoiceController::class, 'storeMaterial']);
Route::post('/storeCustomer', [App\Http\Controllers\APIs\InvoiceController::class, 'storeCustomer']);
Route::get('/getInvoice', [App\Http\Controllers\APIs\InvoiceController::class, 'getInvoice']);

