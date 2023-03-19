<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/theme.css') }}">

    <title>Document</title>
</head>
<body>
    

    @if(session()->has('status'))
         <h3 style="color: green">
         {{session()->get('status')}}
        </h3>
    @endif

    <nav class="navbar navbar-expand navbar-dark bg-success">
        <ul class="nav navbar-nav">
            
            <li class="nav-item ">
                <a class="nav-link" href="{{route('home1') }}">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('about') }}">About</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{route('posts.create') }}">New post</a>
            </li>
            
            <li class="nav-item"> 
                <a class="nav-link" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                </form>
            </li>
            @auth
            <li>
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
            </a>
            

            </li>
            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->email }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
            </li>
            @endauth
            
            
        </ul>
    </nav>

    <div class="container">
        @yield('content')
    </div>
     

     <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>