<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\AuthenticatedSessionController;

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
});
