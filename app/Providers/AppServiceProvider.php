<?php

namespace App\Providers;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('user_is_owner', function(User $user, Apartment $apartment) {
            if($user->admin)
            {
                return true;
            }
            return $user->id == $apartment->owner_id;
        });

        Gate::define('same_user', function(User $user, int $ownerId) {
            if($user->admin)
            {
                return true;
            }
            return $user->id == $ownerId;
        });

        Gate::define('user_is_admin', function(User $user) {
            return $user->admin;
        });
    }
}
