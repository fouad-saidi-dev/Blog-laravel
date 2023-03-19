<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();

        $users = User::all();

        $nbrComments = (int)$this->command->ask("How many of comment you want generate ?",30);


        \App\Models\Comment::factory($nbrComments)->make()->each(function($comment) use ($posts,$users){
            $comment->post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        }); 
    }
}
