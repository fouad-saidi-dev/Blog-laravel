@auth
<h5> Add Comment </h5>
<form action="{{ route('posts.comments.store',['post' => $id ]) }}" method="POST">
    @csrf

    <textarea class="form-control my-3" name="content" id="content"  rows="2"></textarea>

    <x-errors></x-errors>

    <button type="submit" class="btn btn-primary btn-block">Add !</button>

</form>

@else

  <a href="" class="btn btn-success btn-sm">Sing In</a> to post for comment ! <br>

@endauth