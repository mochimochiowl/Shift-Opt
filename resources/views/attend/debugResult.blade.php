<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="{{asset('resources/js/currentTimer.js')}}"></script>
</head>

<body>
    <h1>User {{$pagename}} Result</h1>
    <div>
        <p>{{$pagename}}処理に成功しました。</p>
        <p>入力されたデータ</p>
        <p>staff_id : {{$staff_id}}</p>
        <p>pwd : {{$pwd}}</p>
        <p>current_time : {{$current_time}}</p>
    </div>
    <div>
        <a href="/stamp">打刻画面に戻る</a>
    </div>
    <div>
        <a href="/">トップに戻る</a>
    </div>
</body>

</html>