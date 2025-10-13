<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Blade directive for checking permissions
        Blade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->can($permission)): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        // Blade directive for checking roles
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // Blade directive for checking any role
        Blade::directive('hasanyrole', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($roles)): ?>";
        });

        Blade::directive('endhasanyrole', function () {
            return "<?php endif; ?>";
        });

        // Blade directive for checking any permission
        Blade::directive('hasanypermission', function ($permissions) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyPermission($permissions)): ?>";
        });

        Blade::directive('endhasanypermission', function () {
            return "<?php endif; ?>";
        });
    }
}
