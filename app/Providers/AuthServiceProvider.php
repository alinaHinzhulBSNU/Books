<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Book' => 'App\Policies\BookPolicy',
        'App\Models\Author' => 'App\Policies\AuthorPolicy',
        'App\Models\Publisher' => 'App\Policies\PublisherPolicy',
        'App\Models\Genre' => 'App\Policies\GenrePolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Для адміністратора
        Gate::define('admin', function($user){
            return $user->role == 'admin';
        });

        //Для користувача
        Gate::define('surf', function ($user){
           return $user->role == 'user';
        });

        //Для менеджера
        Gate::define('manage', function ($user){
            return $user->role == 'manager';
        });
    }
}
