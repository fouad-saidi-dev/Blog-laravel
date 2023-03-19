<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StoreComment;

class PostCommentController extends Controller
{
    public function store(StoreComment $request,Post $post){
        //dd($post); for test

        $post->comments()->create([
              'content' => $request->content,
              'user_id' => $request->user()->id
        ]);

        return redirect()->back(); //back to the original route

    }
}
