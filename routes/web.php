<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\Dashboard;

/* Store */
use App\Http\Livewire\Store\Store;
use App\Http\Livewire\Store\StoreDetails;
use App\Http\Livewire\Store\Form;
use App\Http\Livewire\Store\ExecutiveSummary;

/* User */
use App\Http\Livewire\User\User;


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

/* Dashboard */
Route::get('/',Dashboard::class)->name('dashboard');
Route::get('/dashboard',Dashboard::class)->name('dashboard');


/* Audit */
Route::get('/store',Store::class)->name('store');
Route::get('/store/form/{store_name?}',Form::class)->name('form');
Route::get('/store/details/{store_name?}',StoreDetails::class)->name('details');
Route::get('/store/form/{store_name?}/summary',ExecutiveSummary::class)->name('form.summary');

/* User */
Route::get('/user',User::class)->name('user');
