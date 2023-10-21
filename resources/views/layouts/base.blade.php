<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <script src="{{asset('/dist/main.js')}}"></script>
    @vite('resources/css/app.css')
    </head>
    <body class="bg-blue-300"">
        @section('header')
            <header class="flex items-center w-full">
                <a href="{{route('top')}}" class="inline-block w-1/12">
                    <img src="{{asset('/imgs/logo.png')}}" class="w-full h-auto flex-shrink-0" alt="サイトロゴ画像">
                </a>
                @section('menubar')
                    <ul class="flex box-border justify-around py-3 w-11/12 ml-5">
                        @if (Auth::check())
                            @if (Auth::user()->isAdmin())
                            <li><a href="{{route('users.create')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">スタッフ登録画面</a></li>
                            <li><a href="{{route('stamps.index')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">打刻画面</a></li>
                            <li><a href="{{route('users.search')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">{{ConstParams::USER_JP}}検索画面</a></li>
                            <li><a href="{{route('at_records.search')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">{{ConstParams::AT_RECORD_JP}}検索画面</a></li>
                            <li><a href="{{route('summary.index')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">サマリー画面</a></li>
                            @endif
                        @endif
                        <li><a href="{{route('debug')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">CSS確認</a></li>      
                        @if (Auth::check())
                        <li><a href="{{route('logout')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">ログアウトする</a></li>
                        @else
                        <li><a href="{{route('login.form')}}" class="flex-1 box-border text-center px-6 py-3 rounded-xl  transition-colors duration-300 text-black bg-blue-400 hover:text-gray-200 hover:bg-blue-800">ログインする</a></li>
                        @endif
                    </ul>
                @show
            </header>  
        @show
        <h1 class="text-4xl menu container mx-auto p-3">@yield('title')</h1>
        <div class="menu container mx-auto p-3">
            @yield('content')
        </div>
        <footer class="px-3 py-5 bg-blue-500 text-sm text-gray-200 text-center">
            @yield('footer')
        </footer>
    </body>
</html>