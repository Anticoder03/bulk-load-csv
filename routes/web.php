<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer as CustomerController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer/import', [CustomerController::class, 'import'])->name('customer.import');
Route::get('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
