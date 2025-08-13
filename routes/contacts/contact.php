<?php

use App\Http\Controllers\Contact\ContactController;
use Illuminate\Support\Facades\Route;

// Additional route for trashed accounts

Route::middleware('IsUserValid')->group(function () {
    Route::get('contacts/trash', [ContactController::class, 'trash'])->name('contacts.trash');
    Route::resource('contacts', ContactController::class);
    Route::get('contacts/restore/{id}', [ContactController::class, 'restore'])->name('contacts.restore');
    Route::delete('contacts/force-delete/{id}', [ContactController::class, 'forceDelete'])->name('contacts.forceDelete');
    Route::post('contacts/mass-update', [ContactController::class, 'massUpdate'])->name('contacts.massUpdate');
});
