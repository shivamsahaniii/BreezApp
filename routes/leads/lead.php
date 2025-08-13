<?php

use App\Http\Controllers\Lead\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('leads/trash', [LeadController::class, 'trash'])->name('leads.trash');
Route::resource('leads', LeadController::class);
Route::get('leads/restore/{id}', [LeadController::class, 'restore'])->name('leads.restore');
Route::delete('leads/force-delete/{id}', [LeadController::class, 'forceDelete'])->name('leads.forceDelete');


Route::post('/leads/mass-update', [LeadController::class, 'massUpdate'])->name('leads.massUpdate');