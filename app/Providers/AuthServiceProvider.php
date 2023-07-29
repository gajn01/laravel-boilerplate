<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('allow-view', fn (User $user, $module) =>
             $this->checkUserAccess($user, $module, 0, true)
        );
        Gate::define('allow-create', fn (User $user, $module) =>
             $this->checkUserAccess($user, $module, 1, true)
        );
        Gate::define('allow-edit', fn (User $user, $module) =>
             $this->checkUserAccess($user, $module, 2, true)
        );
        Gate::define('allow-delete', fn (User $user, $module) =>
             $this->checkUserAccess($user, $module, 3, true)
        );
        Gate::define('access-enabled', fn (User $user, $module) =>
             $this->checkUserAccess($user, $module, 0, false)
        );
    }
    private function checkUserAccess(User $user, $module, $requiredAccessLevel, $checkEnabled)
    {
        $checkIfUserIsAdmin = $user->user_type < 2;
        $checkIfUserAccessIsNull = !$user->userAccessArray;
        if ($checkIfUserIsAdmin) {
            return true;
        }
        if ($checkIfUserAccessIsNull) {
            return false;
        }
        foreach ($user->userAccessArray as $access) {
            $isAccessModuleSame = $access['module'] === $module;
            $isAccessLevelGreaterThanRequired = $access['access_level'] >= $requiredAccessLevel;
            $isEnabled = !$checkEnabled || $access['enabled'];
            if ($isAccessModuleSame && $isEnabled && $isAccessLevelGreaterThanRequired) {
                return true;
            }
        }
        return false;
    }
}