<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
/* Login */
use App\Http\Livewire\Auth\Login;
/* Dashboard */
use App\Http\Livewire\Dashboard\Dashboard;
/* report */
use App\Http\Livewire\Report\Aggregate;
use App\Http\Livewire\Report\Summary;
/* Log */
use App\Http\Livewire\Log\ActivityLog;
/* Audit */
use App\Http\Livewire\Audit\Audit as Audit;
use App\Http\Livewire\Audit\Form as AuditForm;
use App\Http\Livewire\Audit\Summary as AuditSummary;
use App\Http\Livewire\Audit\Result as AuditResult;
use App\Http\Livewire\Audit\Schedule as AuditSchedule;
use App\Http\Livewire\Audit\Details as AuditDetails;
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
use App\Http\Livewire\Settings\Dropdown;
use App\Http\Livewire\Settings\DropdownMenu;
use App\Http\Livewire\Settings\CriticalDeviation;
use App\Http\Livewire\Settings\CriticalDeviationMenu;
/*Store  */
use App\Http\Livewire\Store\Store;
use App\Http\Livewire\Store\StoreDetails;
use App\Http\Livewire\Store\Capa;
use App\Http\Livewire\Store\CapaResult;
/* Dashboard */
Route::get('/', [NavigationController::class,'index'])->name('home');
Route::get('/login', Login::class)->name('login');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    /* Schedule */
    Route::get('/schedule', AuditSchedule::class)->name('audit.schedule');
    Route::get('/store', Store::class)->name('store');
    Route::get('/store/details/{store_id?}', StoreDetails::class)->name('store-details');
    Route::get('/store/capa', Capa::class)->name('capa');
    Route::get('/store/capa/result/{id}', Capa::class)->name('capa-result');

     /* Audit */
     Route::get('/audit', Audit::class)->name('audit');
     Route::get('/store/details/{store_id?}', AuditDetails::class)->name('audit.details');
     Route::get('/audit/form/{id}', AuditForm::class)->name('audit.form');
     Route::prefix('result/{form_id?}')->group(function () {
         Route::get('/', AuditResult::class)->name('audit.result');
         Route::get('/summary', AuditSummary::class)->name('audit.summary');
         Route::get('/view/{summary_id?}', AuditResult::class)->name('audit.view.result');
         Route::get('/view/{summary_id?}/summary', AuditSummary::class)->name('audit.view.summary');
     });
    /* Settings */
    Route::get('/settings/category', Category::class)->name('category');
    Route::get('/settings/category/details/{category_id?}', CategoryDetails::class)->name('category-details');
    Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}', SubCategoryLabel::class)->name('sub-category-label');
    Route::get('/settings/category/details/{category_id?}/label/{sub_category_id?}/sub-category/{sub_sub_category_id?}', SubSubCategoryLabel::class)->name('sub-sub-category-label');
    Route::get('/settings/sanitary', Sanitary::class)->name('sanitary');
    Route::get('/settings/dropdown', Dropdown::class)->name('dropdown');
    Route::get('/settings/dropdown/menu/{dropdown_id?}', DropdownMenu::class)->name('dropdown-menu');
    Route::get('/settings/critical-deviation', CriticalDeviation::class)->name('critical-deviation');
    Route::get('/settings/critical-deviation/menu/{critical_deviation_id?}', CriticalDeviationMenu::class)->name('critical-deviation-menu');
    /* User */
    Route::get('/user-management', User::class)->name('user-management');
    Route::get('/user/details/{id}', UserDetails::class)->name('user-details');
    Route::get('/user/profile', Profile::class)->name('profile');
    Route::get('/user/change-password', ChangePassword::class)->name('change-password');
    /* Report */
    Route::get('/insight/aggregate', Aggregate::class)->name('aggregate');
    Route::get('/insight/summary', Summary::class)->name('summary');
    Route::get('/activity-log', ActivityLog::class)->name('activity-log');
});
require __DIR__ . '/auth.php';
