<?php

use App\Http\Controllers\Account\AccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('IsUserValid')->group(function () {
    Route::get('accounts/trash', [AccountController::class, 'trash'])->name('accounts.trash');
    Route::resource('accounts', AccountController::class);
    Route::get('accounts/restore/{id}', [AccountController::class, 'restore'])->name('accounts.restore');
    Route::delete('accounts/force-delete/{id}', [AccountController::class, 'forceDelete'])->name('accounts.forceDelete');
    Route::post('accounts/mass-update', [AccountController::class, 'massUpdate'])->name('accounts.massUpdate');
});

