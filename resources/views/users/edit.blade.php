@extends('layout')

@section('content')

<form action="{{ route('users.update',['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
   @method('PUT') 
   @csrf
    <div class="row">
        <div class="col-md-4">
            <h5>Select a difference Avatar</h5>
            <img src="" alt="" class="img-thumbnail avatar">
            <input type="file" name="avatar" id="avatar" class="form-control-file">        
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
    </div>
</form>

@endsection
