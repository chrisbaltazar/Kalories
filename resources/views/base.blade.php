<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" id ="token" content="{{ csrf_token() }}">

        <title>Kalories application</title>

        <!-- Styles -->
        <link rel="stylesheet" href ="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
        @yield ('style')
        
    </head>
    <body>
        <div class="container">
            
            @if(auth()->check()) 
            
                @include('navbar') 
              
                @if(Request::path() == 'home') 
                
                <div class="jumbotron">
                    <h1 class="display-4">Welcome to Kalories Application</h1>
                    @if(auth()->user()->hasRole('ADMIN'))
                    <p class="lead">As an ADMIN, here you can manage all the system options, like the User's access and settings.</p>
                    @else 
                    <p class="lead">As an USER, here you can register and follow your own Calories History.</p>
                    @endif 
                  </div>
                
                @endif
                
            @endif
            
            @yield ('content') 

        </div>

        <script src ="{{ asset('js/app.js') }}"></script> 
        <script src ="{{ asset('js/jquery-ui/jquery-ui.js') }}"></script> 
        <script src ="{{ asset('js/fn.js') }}"></script> 
        @yield ('script')
    </body>
</html>
