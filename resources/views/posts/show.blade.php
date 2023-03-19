@extends('layout')

@section('content')

 <div class="row">
      <div class="col-8">
      <h2>{{ $post -> title }}</h2>
      @if($post->image)
        <img src="{{ $post->image->url()  }}" alt="" class="img-fluid roundred">
      @endif
      
         <p>{{ $post -> content }}</p>

         <x-tags :tags="$post->tags"></x-tags>

         <p>Added {{ $post->created_at->diffForHumans() }} </p>

         @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5 )
            <strong>Now !</strong>
         @endif
         
         <h1>Comments</h1>
 

         <hr>

         @include('comments.form',['id' => $post->id])
         
         <hr>
 
      @forelse($post->comments as $comment)
           <p>{{ $comment->content}}</p>
           
         
    <!--    <p class="text-muted"> added {{ $comment->updated_at->diffForHumans() }}  </p> -->
        <x-updated :date="$comment->created_at" :name="$comment->user->name"></x-updated>

        @empty
           <p>No comments yet !</p>
         @endforelse 
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