@extends('layout')
@section('content')

<div class="row">
    <div class="col-8">
    <h1>List of posts</h1>


<div class="my-3" >
    <h4> {{ $posts->count() }} Post(s) </h4>
</div>

<ul class="list-group">

    @forelse($posts as $post)
    <li class="list-group-item">
    
        @if($post->created_at-> diffInHours() < 1)
            <x-badge type="success">New</x-badge>
        @else
           <x-badge type="dark">Old</x-badge>
        @endif

        @if($post->image)
        <img src="{{ $post->image->url()  }}" alt="" class="img-fluid roundred">
        @endif

        <h2>
            <a style="text-decoration:none;" href="{{route('posts.show',['post' => $post-> id]) }}">
              @if($post->trashed())
            
             <del>
              {{ $post-> title }}
             </del>
             @else
             {{ $post-> title }}
              @endif
            </a>
        </h2>


        <x-tags :tags="$post->tags"></x-tags>

        <p>{{ $post-> content }}</p>
        <em>{{ $post-> created_at}}</em>

        @if($post->comments_count)
        <div>
            <span class="badge bg-secondary" >{{ $post->comments_count}} comments</span> 
        </div>
        @else
        <div>
            <span class="badge bg-secondary" >{{ $post->comments_count}} no comments yet !</span> 
        </div>
        @endif

        <!--<p class="text-muted">
            {{ $post->updated_at->diffForHumans() }}, by {{ $post->user->name }}
        </p>-->

        <x-updated :date="$post->created_at" :name="$post->user->name" :user-id="$post->user->id"></x-updated>
        <x-updated :date="$post->updated_at" >Updated</x-updated>
    @auth    
        @can('update',$post)
        <a class="btn btn-warning" href="{{route('posts.edit',['post' => $post->id]) }}">Edit</a>
        @endcan

        @cannot('delete',$post)
             @component('partials.badge',['type'=>'danger'])
                 You can't delete this post
             @endcomponent
        @endcannot

        <!--delete-->
        @if(!$post->deleted_at)
          @can('delete',$post)
        <form style="display: inline;" action="{{route('posts.destroy',['post' => $post->id]) }}" method="POST">
            @csrf 
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
          @endcan

        @else
        @can('restore',$post)
        <form style="display: inline;" action="{{url('/posts/'.$post->id.'/restore') }}" method="POST">
            @csrf 
            @method('PATCH')
            <button type="submit" class="btn btn-success">Restore</button>
        </form>
        @endcan
        @can('forceDelete',$post)
        <form style="display: inline;" action="{{url('/posts/'.$post->id.'/forcedelete') }}" method="POST">
            @csrf 
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endcan
        @endif
    </li>
    @endauth

    @empty
       <span class="badge badge-danger">Not posts</span>

    @endforelse
</ul>
    </div>
    <div class="col-4 mt-5 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Most Post Commented</h4>
            </div>
            <ul class="list-group list-group-flush">
               @foreach($postCommented as $post) 
                <li class="list-group-item">
                    <a href="">{{ $post->title }}</a>
                    <p><span class="badge bg-success">{{ $post->comments_count}} comments</span></p>
                </li>
                
               @endforeach 
            </ul>
        </div>

        <div class="card mt-4">
            <div class="card-body" style="margin-top:3%;">
                <h4 class="card-title">Most Users posted</h4>
            </div>
            <ul class="list-group list-group-flush">
               @foreach($mostUsersActive as $user) 
                <li class="list-group-item">
                    {{ $user->name }}
                    <p><span class="badge bg-success">{{ $user->posts_count}} comments</span></p>
                </li>
                
               @endforeach 
            </ul>
        </div>

        <div class="card mt-4">
            <div class="card-body" style="margin-top:3%;">
                <h4 class="card-title">Most Active Users posted</h4>
            </div>
            <ul class="list-group list-group-flush">
               @foreach($mostUsersActiveInLastMonth as $user) 
                <li class="list-group-item">
                    {{ $user->name }}
                    <p><span class="badge bg-success">{{ $user->posts_count}} comments</span></p>
                </li>
                
               @endforeach 
            </ul>
        </div>

    </div>

    
</div>


@endsection
