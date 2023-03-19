<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(Auth::id()); //afficher l'id de user authentifier 
        //dd(Auth::user()); //afficher les informations de user auth
        //dd(Auth::user()->email); afficher email de user authentifie
        //dd(Auth::check()); //check email
        return view('home');
    }

    public function secret(){
        return view('secret');
    }





    public function home(){
        return view('home1');
    }

    public function about(){
        return view('about');
    }

    public function blog($myId,$author='by default'){
        $posts=[
        1 => ['title' => 'learn laravel'],
        2 => ['title' => 'learn angular'],
    ];
    
    return view('posts.show',[
        'data' => $posts[$myId],
        'author' => $author
    ]);
    }
}
