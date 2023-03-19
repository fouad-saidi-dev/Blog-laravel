    @foreach($tags as $tag)
       <span class="badge bg-info"><a href="{{ route('posts.tags',['id' => $tag->id]) }}">{{ $tag->name }}</a></span>
    @endforeach