<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get(
    '/cetak/invoice/{id}',
    [
        \App\Http\Controllers\CetakInvoiceController::class,
        'cetak'
    ]
);
