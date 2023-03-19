<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class PostTagController extends Controller
{
    public function index($id){
         
        $tag = Tag::find($id);

        return view('posts.index',[
            'posts' => $tag->posts()->withCount('comments')->with(['user','tags'])->get(),
            
        ]);
    }
}
