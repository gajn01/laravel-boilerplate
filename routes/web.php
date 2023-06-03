<?php
use Illuminate\Support\Facades\Route;
/* Login */
use App\Http\Livewire\Auth\Login;
/* Dashboard */
use App\Http\Livewire\Dashboard\Dashboard;
/* Schedule */
use App\Http\Livewire\Store\Schedule;


/* Store */
/* use App\Http\Livewire\Store\Store;
use App\Http\Livewire\Store\StoreDetails;
use App\Http\Livewire\Store\Form;
use App\Http\Livewire\Store\ExecutiveSummary; */
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
use App\Http\Livewire\Settings\StoreSettings;
use App\Http\Livewire\Settings\Dropdown;
use App\Http\Livewire\Settings\DropdownMenu;
use App\Http\Livewire\Settings\CriticalDeviation;
use App\Http\Livewire\Settings\CriticalDeviationMenu;

// $controller_path = 'App\Http\Livewire';
/* Login */
/* Dashboard */
Route::get('/login', Login::class)->name('login');
Route::redirect('/', '/dashboard');
Route::middleware(['auth'])->group(function () {
    // Only users with user_level = 0 can access the following routes
    Route::middleware(['level:0'])->group(function () {
        /* Dashboard */
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        /* Schedule */
        Route::get('/schedule', AuditSchedule::class)->name('audit.schedule');
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
    // Only users with user_level != 0 can access the following routes
    Route::middleware(['level:0,1,2,3'])->group(function () {
        /* Audit */
        Route::get('/audit', Audit::class)->name('audit');
        Route::get('/audit/details/{store_id?}', AuditDetails::class)->name('audit.details');
        Route::get('/audit/form/{store_id?}', AuditForm::class)->name('audit.form');
        Route::prefix('result/{store_id?}')->group(function () {
            Route::get('/', AuditResult::class)->name('audit.result');
            Route::get('/summary', AuditSummary::class)->name('audit.summary');
            Route::get('/view/{result_id?}', AuditResult::class)->name('audit.view.result');
            Route::get('/view/{result_id?}/summary/{summary_id?}', AuditSummary::class)->name('audit.view.summary');
        });
        /* store */
        /* Route::get('/audit', Store::class)->name('audit'); */
        /*  Route::get('/store/form/{store_id?}', Form::class)->name('form');
         Route::get('/store/details/{store_id?}', StoreDetails::class)->name('details');
         Route::get('/store/form/{store_id?}/result', AuditResult::class)->name('form.result');
         Route::get('/store/form/{store_id?}/result/summary', ExecutiveSummary::class)->name('form.summary'); */
        /* User */
        Route::get('/user', User::class)->name('user');
        Route::get('/user/information/{employee_id?}', UserDetails::class)->name('information');
        Route::get('/user/profile', Profile::class)->name('profile');
        Route::get('/user/change-password', ChangePassword::class)->name('change-password');
    });
});

require __DIR__ . '/auth.php';
