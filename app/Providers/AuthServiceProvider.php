<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('canControlEverything', function($user) {
            return $user->role->name === 'super';
        });

        Gate::define('canWorkOnPost', function($user) {
            return $user->role->name === 'admin' || $user->role->name === 'editor' || $user->role->name === 'super';
        });

        Gate::define('canWorkOnNewsletter', function($user) {
            return $user->role->name === 'admin' || $user->role->name === 'editor' || $user->role->name === 'super';
        });

        Gate::define('canWorkOnSubscription', function($user) {
            return $user->role->name === 'admin' || $user->role->name === 'super';
        });

        Gate::define('canControlOrganization', function($user) {
            return $user->role->name === 'admin' || $user->role->name === 'super';
        });

        Gate::define('canControlPost', function($user, $post) {
            return $user->role->name === 'admin' || $user->role->name === 'super' || $user->id === $post->user_id;
        });
    }
}
