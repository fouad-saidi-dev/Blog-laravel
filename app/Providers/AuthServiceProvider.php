<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();



        //for all methods
        Gate::resource('post','App\Policies\PostPolicy');

        Gate::define('secret.page' , function($user){
            return $user->is_admin;
        });
        //Gate::define('post.update','App\Policies\PostPolicy@update');
        //Gate::define('post.dalete','App\Policies\PostPolicy@dalete');
        
        
        //Gate::define('post.update', function (User $user, Post $post) {
        //    return $user->id === $post->user_id;
        //});

        //Gate::define('post.delete', function (User $user, Post $post) {
        //    return $user->id === $post->user_id;
        //});

        Gate::before(function($user , $ability){
            if($user->is_admin && in_array($ability,["restore","update","forceDelete","delete"])){ //restore update :: method from PostPolicy
                return true;
            }
        });
    }
}
