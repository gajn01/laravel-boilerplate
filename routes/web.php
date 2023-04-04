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
use App\Http\Livewire\User\UserDetails;

/* Settings */
use App\Http\Livewire\Settings\Category;
use App\Http\Livewire\Settings\Sanitary;
use App\Http\Livewire\Settings\StoreSettings;



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
Route::get('/user/information/{user_id?}',UserDetails::class)->name('information');

/* Settings */
Route::get('/settings/store-settings',StoreSettings::class)->name('settings');
Route::get('/settings/category',Category::class)->name('category');
Route::get('/settings/sanitary',Sanitary::class)->name('sanitary');
