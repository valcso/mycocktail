<html>
<head>
    <meta charset='UTF-16'>
    <title>Cocktail App</title>
    <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script src="https://kit.fontawesome.com/ec2a35f277.js" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Reenie+Beanie&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class='wrapper'>
    <div class='container-fluid' id='cont'>
 <!--<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
        </div> -->
      
        <nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm" id='navBar'>
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}" style='display:flex;'>
                   <img src='images/logo.gif' width="5%"> <h6 id='navBrand'>Cocktail app</h6> 
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}<i class="fas fa-sign-in-alt"></i></a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }} <i class="fas fa-edit"></i></a> 
                                </li>
                            @endif
                        @else
                     
                        <li class="nav-item" id='navBox'>
                            <img src="images/drink-glass-with-soda-and-straw.svg" id='navIcons'>
                            <a id='navItem' href='http://localhost:81/cocktailAPP/public/home'class="nav-link">Ordinary drink</a> 
                        </li>
                        <li class="nav-item" id='navBox'>
                            <img src="images/cola.svg" id='navIcons'>
                            <a id='navItem' href='http://localhost:81/cocktailAPP/public/nonAlc' class="nav-link">Non alcoholic</a> 
                        </li>
                        <li class="nav-item" id='navBox'>
                            <img src="images/coconut-drink.svg" id='navIcons'>
                            <a id='navItem' href='http://localhost:81/cocktailAPP/public/cocktail' class="nav-link">Cocktail</a> 
                        </li>
                        <li class="nav-item" id='navBox'>
                            <img src="images/shot.svg" id='navIcons'>
                            <a id='navItem'href='http://localhost:81/cocktailAPP/public/shot' class="nav-link">Shot</a> 
                        </li>
                        <li class="nav-item" id='navBox'>
                            <img  src="images/searching.svg" id='navIcons' onclick='search(1)'>
                            <!--<i class="fas fa-search" id='search' onclick='search(1)'></i>-->
                        </li>
                 
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



            @endif
            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12' id='welcomeCol'>
                <div class='row' id='welcomeRow'>
                @yield('content')
                <div class='col-xl-6 col-lg-6' id='searchForm'>
                    <i class="fas fa-times-circle" id='closeSearch' onclick='search(2)'></i>
                    <span id='ldg'>
                      
                    </span>
                    <div class="input-group mb-3" id='iGroup'>
                        <div class="input-group-prepend">
                        
                        </div>
                        <input type="text" id='srch' class="form-control" placeholder="Start typing... (eg.'Vodka', 'Orange', 'Gin')" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12' id='searchResponse'>
        
                      </div>
                    </div>
                </div>
                <div class='row' id='comments'>
                    @yield('comments')
                </div>
            </div>   
            
        </div>
    
       
        </div>
        <div  class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12' id='footer'>
            <div class='col-xl-6 col-lg-6 col-md-6 col-sm-6' id='footerInner'>
                <a href='https://github.com/valcso' target='_blank'><i class="fab fa-github-square"  style='font-size:25px;'></i></a>&nbsp;|&nbsp;&nbsp;&copy; <a id='copyRight'>All rights reserved</a>&nbsp;&nbsp;|&nbsp;<a href='https://www.thecocktaildb.com/' target="_blank">API</a>
            </div>
            </div>
       

    </body>

</html>