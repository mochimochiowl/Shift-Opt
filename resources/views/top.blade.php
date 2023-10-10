<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>トップ画面</title>
    </head>
    <body>
        <h1>トップ画面</h1>
        <div>
            <a href="{{route('users.create')}}">スタッフ登録画面</a>
        </div>
        <div>
            <a href="{{route('stamps.index')}}">打刻画面</a>
        </div>
        <div>
            <a href="{{route('users.search')}}">Userテーブル検索画面</a>
        </div>
        @if (Auth::check())
        <p>{{Auth::user()->kanji_last_name . Auth::user()->kanji_first_name}}さん、こんにちは</p>
        <div>
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit">ログアウトする</button>
            </form>
        </div>
        @else
        <p>ログインしていません</p>
        <div>
            <a href="{{route('login.form')}}">ログインする</a>
        </div>
        @endif
    </body>
</html>
