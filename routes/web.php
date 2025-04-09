<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmoAuthController;
use App\Http\Controllers\LeadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/amo-auth/redirect', [AmoAuthController::class, 'redirect'])->name('amo.redirect');
Route::get('/amo-auth/callback', [AmoAuthController::class, 'callback'])->name('amo.callback');
Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
