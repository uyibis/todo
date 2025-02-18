<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <title>{{ config('app.name', 'TodoList') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script src="https://use.fontawesome.com/186d66fd50.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                font-family: 'Baloo Da 2', cursive;
                background-color: #F8F8FF;
            }
        </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>

    <header class="container py-3 d-flex justify-content-between align-items-center">
        <h1 class="mb-0">My ToDo</h1>
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark me-2">Home</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark me-2">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-dark">Register</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

        <main id="app">
          <todo></todo>
        </main>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
