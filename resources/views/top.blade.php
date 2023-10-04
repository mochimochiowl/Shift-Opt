<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body>
        <h1>Topページ</h1>
        <div>
            <a href="/register">スタッフ登録画面</a>
        </div>
        <div>
            <a href="/stamp">打刻画面</a>
        </div>
        @if (Auth::check())
        <p>{{Auth::user()->kanji_last_name . Auth::user()->kanji_first_name}}さん、こんにちは</p>
        <div>
            <form action="logout" method="post">
                @csrf
                <input type="submit" value="ログアウトする">
            </form>
        </div>
        @else
        <p>ログインしていません</p>
        <a href="/login">ログインする</a>
        @endif
    </body>
</html>
