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
        <div>
            <p>入力されたデータ</p>
            <p>staff_id : {{$staff_id}}</p>
            <p>pwd : {{$pwd}}</p>
            <p>current_time : {{$current_time}}</p>
        </div>
        <form action="/stamp" method="post">
            @csrf
            <div>
                <span>スタッフID</span>
                <input type="text" name="staff_id">
            </div>
            <div>
                <span>パスワード</span>
                <input type="password" name="pwd">
            </div>
            <div>
                <input type="submit" value="出勤" formaction="/stamp/debugShukkin" formmethod="POST">
                <input type="submit" value="退勤" formaction="/stamp/debugTaikin" formmethod="POST">
            </div>
        </form>
        <a href="/">トップに戻る</a>
    </body>
</html>
