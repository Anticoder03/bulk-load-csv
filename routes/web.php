<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer as CustomerController;

Route::get('/', function () {
    return view('welcome');
});

// CSV Import Routes
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer/validate', [CustomerController::class, 'validate'])->name('customer.validate');
Route::post('/customer/process', [CustomerController::class, 'process'])->name('customer.process');

// Contact Form Routes
use App\Http\Controllers\ContactController;

Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

