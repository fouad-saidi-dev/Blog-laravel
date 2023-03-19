<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\User;


class ActivityComposer{

    

    public function compose(View $view){
    
       $postCommented = Cache::remember('postCommented',now()->addSeconds(10),function(){
            return Post::mostCommented()->take(5)->get();
       });

       $mostUsersActive = Cache::remember('mostUsersActive',now()->addSeconds(10),function(){
            return User::mostUsersActive()->take(5)->get();
       });

       $mostUsersActiveInLastMonth = Cache::remember('mostusersActiveInLastMonth',now()->addSeconds(10),function(){
            return User::usersActiveInLastMonth()->take(5)->get();
       });

       $view->with([
          'postCommented' => $postCommented,
          'mostUsersActive' => $mostUsersActive,
          'mostUsersActiveInLastMonth' => $mostUsersActiveInLastMonth
        ]);
    }

}