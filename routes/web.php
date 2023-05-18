<?php
use Illuminate\Support\Facades\Route;
/* Login */
use App\Http\Livewire\Auth\Login;
/* Dashboard */
use App\Http\Livewire\Dashboard\Dashboard;
/* Store */
use App\Http\Livewire\Store\Store;
use App\Http\Livewire\Store\StoreDetails;
use App\Http\Livewire\Store\Form;
use App\Http\Livewire\Store\ExecutiveSummary;
use App\Http\Livewire\Store\AuditResult;
/* User */
use App\Http\Livewire\User\User;
use App\Http\Livewire\User\UserDetails;
use App\Http\Livewire\User\Profile;
use App\Http\Livewire\User\ChangePassword;
/* Settings */
use App\Http\Livewire\Settings\Category;
use App\Http\Livewire\Settings\CategoryDetails;
use App\Http\Livewire\Settings\SubCategoryLabel;
use App\Http\Livewire\Settings\SubSubCategoryLabel;
use App\Http\Livewire\Settings\Sanitary;
use App\Http\Livewire\Settings\StoreSettings;
use App\Http\Livewire\Settings\Dropdown;
use App\Http\Livewire\Settings\DropdownMenu;
use App\Http\Livewire\Settings\CriticalDeviation;
use App\Http\Livewire\Settings\CriticalDeviationMenu;
// $controller_path = 'App\Http\Livewire';
/* Login */
/* Dashboard */
Route::get('/login', Login::class)->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    /* Audit */
    Route::get('/store', Store::class)->name('store');
    Route::get('/store/form/{store_id?}', Form::class)->name('form');
    Route::get('/store/details/{store_id?}', StoreDetails::class)->name('details');
    Route::get('/store/form/{store_id?}/result', AuditResult::class)->name('form.result');
    Route::get('/store/form/{store_id?}/result/summary', ExecutiveSummary::class)->name('form.summary');
    /* User */
    Route::get('/user', User::class)->name('user');
    Route::get('/user/information/{employee_id?}', UserDetails::class)->name('information');
    Route::get('/user/profile', Profile::class)->name('profile');
    Route::get('/user/change-password', ChangePassword::class)->name('change-password');

    /* Settings */
    Route::get('/settings/store-settings', StoreSettings::class)->name('settings');
    Route::get('/settings/category', Category::class)->name('category');
    Route::get('/settings/category/details/{category_id?}', CategoryDetails::class)->name('category-details');
    Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}', SubCategoryLabel::class)->name('sub-category-label');
    Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}/sub-category/{sub_sub_category_id?}', SubSubCategoryLabel::class)->name('sub-sub-category-label');
    Route::get('/settings/sanitary', Sanitary::class)->name('sanitary');
    Route::get('/settings/dropdown', Dropdown::class)->name('dropdown');
    Route::get('/settings/dropdown/menu/{dropdown_id?}', DropdownMenu::class)->name('dropdown-menu');
    Route::get('/settings/critical-deviation', CriticalDeviation::class)->name('critical-deviation');
    Route::get('/settings/critical-deviation/menu/{critical_deviation_id?}', CriticalDeviationMenu::class)->name('critical-deviation-menu');
});
Route::redirect('/', '/dashboard');
require __DIR__ . '/auth.php';
