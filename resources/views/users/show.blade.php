@extends('layout')

@section('content')


    <div class="row">
        <div class="col-md-4">
            <h5> Avatar User </h5>
            <img src="" alt="" class="img-thumbnail avatar">
           
        </div>
        <div class="col-md-8">
            {{ $user->name }}
        </div>
    </div>

@endsection