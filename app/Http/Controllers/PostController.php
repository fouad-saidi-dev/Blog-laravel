<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;




class PostController extends Controller
{

    
    
    public function __construct()
    {
       return $this->middleware('auth')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        //use cache for test rapid 
        /*$postCommented = Cache::remember('postCommented',now()->addSeconds(10),function(){
            return Post::mostCommented()->take(5)->get();
        });
        $mostUsersActive = Cache::remember('mostUsersActive',now()->addSeconds(10),function(){
            return User::mostUsersActive()->take(5)->get();
        });
        $mostUsersActiveInLastMonth = Cache::remember('mostUsersActive',now()->addSeconds(10),function(){
            return User::usersActiveInLastMonth()->take(5)->get();
        });*/

        

        return view('posts.index',[
            'posts' => Post::withCount('comments')->with(['user','tags'])->get() ,
            //'postCommented' => $postCommented ,
            //'mostUsersActive' => $mostUsersActive,
            //'mostUsersActiveInLastMonth' => $usersActiveInLastMonth
        ]);

        //$posts= Post::withCount('comments')->get();
        //$tab="list";
        //return view('posts.index')->with(['posts' => $posts]);

        //mode eager for recuper post with 2 comments and grand database


        //One To Many querying 
        //select all
        //dd(\App\Models\Post::all());
        //mode lazy
        //DB::connection()->enableQueryLog();

        //$posts = Post::with('comments')->get(); //select * from `comments` where `comments`.`post_id` in (1, 2, 4, 5, 6, 7, 8, 9)
       // $posts = Post::all();  select* from posts

        
        //select * from `comments` where `comments`.`post_id` = ? and `comments`.`post_id` 
        /*foreach($posts as $post){
            foreach ($post->comments as $comment) {
                //pour afficher le contenu de chaque objet 
                dump($comment);
            }
        }

        dd(DB::getQueryLog());*/

        
         

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //$this->authorize('post.create');
        return view('posts.create');
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //dd('OK');
        //dd($request -> all());

        //ila siftna form vide validations
        //$request->validate();
/*[
            //bail si trouve une seul error don't work
            //'bail|required|min:4|max:100'

           'title'=> 'required|min:4|max:100',
           'content'=>'required|min:10|max:100'
        ]*/

        /*$hasFile = $request->hasFile("picture");
        dump($hasFile);
        if ($hasFile) {
            $file = $request->file('picture');
            dump($file);
            dump($file->getClientMimeType());
            dump($file->getClientOriginalExtension());
            dump($file->getClientOriginalName());

            $name1 = $file->storeAs('thumbnails', random_int(1,100).'.'.$file->getClientOriginalExtension());
            $name2 = Storage::disk('local')->putFileAs('thumbnails', $file,random_int(1,100).'.'.$file->getClientOriginalExtension());

            dump(storage::url($name1));
            dump(storage::disk('local')->url($name2));
        }

        die();*/


        $post = new Post();
        $post->title=$request->input('title');
        $post->content=$request->input('content');
        
        if ($request->hasFile('picture')) {
            
            $path = $request->file('picture')->store('posts');

            $image = new Image(['path' => $path]);

            $post->image()->save($image);

            //suplimentaires 
            $post->image()->create([
                'path' => $request->path = $path,
                'post_id' => $request->post()->id
          ]);
           
        }

        $post->slug=Str::slug($post->title, '_');
        $post->active=false;

        $post['user_id'] = $request->user()->id;




        $post->save();


        //message
        $request->session()->flash('status','post was created !!');
        
        
        //route
        return redirect()->route('posts.show',['post' => $post->id]);
        //return redirect('/posts');

        //dd('OK');
        //$title=$request->input('title');
        //$content=$request->input('content');

        //dd($title,'content: ',$content);

        //autre method
        //$data=$request->only(['title','content']);
        //slug and active
        //$data['slug']=Str::slug($data['title'],'-');
        //$data['active']=false;
        //$post =Post::create($data);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //select par id
        //dd(\App\Models\Post::find($id));

        //$postShow = Cache::remember("post-show")
        return view('posts.show',[
            'post' => Post::with(['comments','tags','comments.user'])->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post= Post::findOrFail($id);
        
        //$this->authorize("post.update", $post);
        //if(Gate::denies('post.update',$post)){
        //    abort(403,"You can't update this post");
        // }

        return view('posts.edit',[
            'post' => $post 
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
         $post =Post::findOrFail($id);

         //$this->authorize("post.update", $post);
         //if(Gate::denies('post.update',$post)){
         //   abort(403,"You can't update this post");
         //}

         $post->title=$request->input('title');
         $post->content=$request->input('content');
         //$post->slug=Str::slug($request->input('content'),'-');

         if ($request->hasFile('picture')) {
            
            $path = $request->file('picture')->store('posts');

             if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                
                $post->image->save();
             }
             else {
                $image = new Image(['path' => $path]);
                $post->image->save($image);
             }
          
            $image = new Image(['path' => $path]);

            $post->image()->save($image);
        
          
        }

         $post->save();

         $request->session()->flash('status','post was updated !!');

         return redirect()->route('posts.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        //method 1
        $post = Post::findOrFail($id);
        
        //$this->authorize("post.delete", $post);
        
        $post->delete();

        //method 2
        //$post = Post::destroy($id);

        

        $request->session()->flash('status','post was deleted !!');

        return redirect()->route('posts.index');


    }

    //onlyTrashed() : posts deleted
    public function archive(){

        
        //return view('posts.index',[
        //    'posts' => Post::onlyTrashed()->withCount('comments')->get() , 'tab' => 'archive'
        //]);

        $posts = Post::onlyTrashed()->withCount('comments')->get();
        $tab="archive";
        return view('posts.index')->with(['posts' => $data,'tab'=> $tab]);

    }
    

    //withTrashed : all posts deleted and no deleted
    public function all(){
        
        
        //return view('posts.index',compact([
        //    'posts' => Post::withTrashed()->withCount('comments')->get() , 'tab' => 'all'
        //]));
        $posts = Post::withTrashed()->withCount('comments')->get();
        $tab="all";
        return view('posts.index')->with(['posts' => $data,'tab'=> $tab]);
        
    }

    //methd back up restore posts was deleted 
    public function restore($id){
        //dd($id);
        //$this->authorize('post.restore');
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $post->restore();
        return redirect()->back();
    }

    public function forcedelete($id){
        //dd($id);
        $this->authorize('post.forcedelete');
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $post->forceDelete();
        return redirect()->back();

    }
}
