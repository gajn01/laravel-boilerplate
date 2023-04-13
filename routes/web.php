<?php

use Illuminate\Support\Facades\Route;



/* Dashboard */
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
use App\Http\Livewire\Settings\CategoryDetails;
use App\Http\Livewire\Settings\SubCategoryLabel;
use App\Http\Livewire\Settings\SubSubCategoryLabel;
use App\Http\Livewire\Settings\Sanitary;
use App\Http\Livewire\Settings\StoreSettings;
use App\Http\Livewire\Settings\Dropdown;
use App\Http\Livewire\Settings\DropdownMenu;


// $controller_path = 'App\Http\Livewire';

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
Route::get('/settings/category/details/{category_id?}',CategoryDetails::class)->name('category-details');
Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}',SubCategoryLabel::class)->name('sub-category-label');
Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}/sub-category/{sub_sub_category_id?}',SubSubCategoryLabel::class)->name('sub-sub-category-label');
Route::get('/settings/sanitary',Sanitary::class)->name('sanitary');
Route::get('/settings/dropdown',Dropdown::class)->name('dropdown');
Route::get('/settings/dropdown/{dropdown_id?}',DropdownMenu::class)->name('dropdown-menu');


