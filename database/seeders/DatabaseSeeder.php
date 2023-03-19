<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        if ($this->command->confirm("Do you want to refresh the database ?",true)) {
            $this->command->call("migrate:refresh");
            $this->command->info("database has refreshed !");
        }

        $this->call([
            
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            CommentsTableSeeder::class,
            TagTableSeeder::class,
            PostTagTableSeeder::class,
        
        ]);
        
    }
    
    
    
    
    
    
    //factory(App\Models\User::class,10)->created();  
       /*$users = \App\Models\User::factory(10)->create();
        
        $posts = \App\Models\Post::factory(20)->make()->each(function($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = \App\Models\Comment::factory(30)->make()->each(function($comment) use ($posts){
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });*/ 



}
