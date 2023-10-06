<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite('resources/js/currentTimer.js')
    </head>
    <body>
        <h1>User 打刻ページ</h1>
        <div>
            <p id="realTimer">TIMER</p>
        </div>
        @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message') }}
        </div>
        @endif
        <form action="" method="post">
            @csrf
            <div>
                <span>ログインID</span>
                <input type="text" name="login_id">
            </div>
            <div>
                <input type="submit" value="出勤" formaction="/stamp/startWork" formmethod="POST">
                <input type="submit" value="退勤" formaction="/stamp/finishWork" formmethod="POST">
                <input type="submit" value="休憩始" formaction="/stamp/startBreak" formmethod="POST">
                <input type="submit" value="休憩終" formaction="/stamp/finishBreak" formmethod="POST">
            </div>
        </form>
        <a href="/">トップに戻る</a>
    </body>
</html>
