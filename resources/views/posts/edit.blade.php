@extends('layout')
@section('content')

<h1>Edit Post</h1>
<form action="{{ route('posts.update',['post' => $post->id ])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!--<div>
        <label for="title">Your title</label>
        <input name="title" id="title" type="text" value="{{old('title',$post->title)}}" >
    </div>
    <div>
        <label for="content"> Your content</label>
        <input type="text" name="content" id="content" value="{{old('content',$post->content)}}">
    </div>

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif-->
    @include('posts.form')



    <input class="btn btn-block btn-warning" type="submit" value="Update Post" >
</form>

@endsection