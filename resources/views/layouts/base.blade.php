<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    </head>
    <body>
        @section('header')
            <header>
                <a href="{{route('top')}}" class="logo menuBtn">
                    <img src="{{asset('/imgs/logo.png')}}" alt="サイトロゴ画像">
                </a>
                @section('menubar')
                <ul class="menu">
                    <li><a href="{{route('users.create')}}" class="menuBtn">スタッフ登録画面</a></li>
                    <li><a href="{{route('stamps.index')}}" class="menuBtn">打刻画面</a></li>
                    <li><a href="{{route('users.search')}}" class="menuBtn">Userテーブル検索画面</a></li>
                    @if (Auth::check())
                    <li><a href="{{route('logout')}}" class="menuBtn">ログアウトする</a></li>
                    @else
                    <li><a href="{{route('login.form')}}" class="menuBtn">ログインする</a></li>
                    @endif
                </ul>
                @show
            </header>  
        @show
        
        <h1>@yield('title')</h1>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            @yield('footer')
        </div>
    </body>
</html>