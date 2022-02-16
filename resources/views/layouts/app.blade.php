<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="bg-gray-700 flex justify-between px-10 items-center py-6">
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}">
                    <h1 class="text-white font-bold text-2xl cursor-pointer">{{ config('app.name', 'Laravel') }}</h1>
                </a>
            </div>
            <div class="flex items-center space-x-8 font-bold text-white">
                @guest
                <a href="{{ route('login') }}"><span class="cursor-pointer text-md">Login</span></a>
                <a href="{{ route('register') }}"><span class="cursor-pointer text-md">Register</span></a>
                @else
                <span class="cursor-pointer text-md">{{ Auth::user()->name }}さん</span>
                <form action="{{ route('logout') }}" method="post" id="logout-form">
                    @csrf
                    <span class="cursor-pointer text-md" onclick="document.getElementById('logout-form').submit();">Logout</span>
                </form>
                @endguest
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
