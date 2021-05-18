<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','') | {{ config('app.name', 'CARTAC') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/constantes.js') }}" ></script>
    <script src = "https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src = "https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">



    
    
    
    
</head>
<body @isset($class_body) class='{{$class_body}}' @endisset>
    <div id="app">
        @if (Auth::check())
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="close-menu-horizontal"><i class="fas fa-arrow-left menu-icono"></i></div>
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="brand-header"><img src="{{asset('imgs/theme/logo.png')}}" /></div>
                {{ config('app.name', 'Cartac') }}
            </a>
            
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                @isset(Auth::user()->photo)
                                    <div class="cont-user-image">
                                        <img src="{{Storage::url(Auth::user()->photo)}}" class="user-image" />
                                    </div>
                                @endisset
                            </a>

                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.update') }}">Modificar Perfil</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>            
        </nav>
        @endif
        <div class="row mx-0">
            @if (Auth::check())
            <div class="col-2 px-0 contenedor-menu-horizontal activo">
                <div class="menu-horizontal">
                    <ul class="menu">
                        <li><a href="{{ route('peajes.index')}}" @if (str_contains(Route::current()->getName(),'peajes'))
                            class="activo"
                        @endif>Peajes</a></li>
                        <li><a href="{{ route('categorias.index')}}" @if (str_contains(Route::current()->getName(),'categorias'))
                            class="activo"
                        @endif>Categorias</a></li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#sub-menu1" aria-expanded="false">CATEGORIA <i class="fas fa-sort-down"></i></a> 
                            <ul class="sub-menu collapse" id="sub-menu1">
                                <li><a href="#">SUB CATEGORIA 1</a></li>
                                <li><a href="#">SUB CATEGORIA 2</a></li>
                                <li><a href="#">SUB CATEGORIA 3</a></li>
                            </ul>                
                        </li>
                        <li><a href="#">CATEGORIA 2</a></li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#sub-menu3" aria-expanded="false">CATEGORIA 3 <i class="fas fa-sort-down"></i></a> 
                            <ul class="sub-menu collapse" id="sub-menu3">
                                <li><a href="#">SUB CATEGORIA 1</a></li>
                                <li><a href="#">SUB CATEGORIA 2</a></li>
                                <li><a href="#">SUB CATEGORIA 3</a></li>
                            </ul>  
                        </li>
                        <li><a href="#">CATEGORIA 2</a></li>
                    </ul>
                </div>
                
            </div>
            @endif
            <div class="col">
                <main>
                    @yield('content')
                </main>
            </div>            
        </div>        
    </div>
    <script>
        $(document).ready(() => {
            $(".close-menu-horizontal").click(()=>{
                if($(".contenedor-menu-horizontal").hasClass("activo")){
                    $(".contenedor-menu-horizontal").removeClass("activo");
                    $(".menu-icono").removeClass("fa-arrow-left");
                    $(".menu-icono").addClass("fa-bars");
                }
                else{
                    $(".contenedor-menu-horizontal").addClass("activo");
                    $(".menu-icono").addClass("fa-arrow-left");
                    $(".menu-icono").removeClass("fa-bars");
                }
            });
        });
    </script>
</body>
</html>
