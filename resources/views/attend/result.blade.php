<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>打刻処理成功画面</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="{{asset('resources/js/currentTimer.js')}}"></script>
</head>

<body>
    <h1>打刻処理成功画面</h1>
    <div>
        <p>処理に成功しました。</p>
        <p>入力されたデータ</p>
        <p>ログインID : {{$login_id}}</p>
        <p>お名前 : {{$name}} さん</p>
        <p>種別 : {{$type}}</p>
        <p>打刻時間 : {{$time}}</p>
    </div>
    <div>
        <a href="/stamp">打刻画面に戻る</a>
    </div>
    <div>
        <a href="/">トップに戻る</a>
    </div>
</body>

</html>