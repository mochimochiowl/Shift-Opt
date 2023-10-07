<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>打刻画面</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        {{-- @vite('resources/js/currentTimer.js') --}}
    </head>
    <body>
        <h1>打刻画面</h1>
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
                <span>{{ConstParams::LOGIN_ID_JP}}</span>
                <input type="text" name="login_id">
            </div>
            <div>
                <input type="submit" value="{{ConstParams::AT_RECORD_START_WORK_JP}}" formaction="/stamp/startWork" formmethod="POST">
                <input type="submit" value="{{ConstParams::AT_RECORD_FINISH_WORK_JP}}" formaction="/stamp/finishWork" formmethod="POST">
                <input type="submit" value="{{ConstParams::AT_RECORD_START_BREAK_JP}}" formaction="/stamp/startBreak" formmethod="POST">
                <input type="submit" value="{{ConstParams::AT_RECORD_FINISH_BREAK_JP}}" formaction="/stamp/finishBreak" formmethod="POST">
            </div>
        </form>
        <a href="/">トップに戻る</a>
    </body>
</html>
