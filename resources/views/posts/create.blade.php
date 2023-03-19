@extends('layout')
@section('content')

<h1>New Post</h1>
<form action="{{ route('posts.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <!--<div>
        <label for="title">Your title</label>
        <input name="title" id="title" type="text" value="{{old('title')}}" >
    </div>
    <div>
        <label for="content"> Your content</label>
        <input type="text" name="content" id="content" value="{{old('content')}}">
    </div>

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif-->

    @include('posts.form')



    <input class="btn btn-block btn-primary" type="submit" value="Add Post">
</form>

@endsection