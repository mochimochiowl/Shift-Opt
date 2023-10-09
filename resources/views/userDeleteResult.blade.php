<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ユーザー情報削除処理成功画面</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body>
    <h1>ユーザー情報削除処理成功画面</h1>
    <div>
        <p>データ を削除しました。</p>
        <p>削除した項目数：{{$count}}</p>
    </div>
    <div>
        <div>
            <a href="{{route('users.search')}}">ユーザー検索画面に戻る</a>
        </div>
        <div>
            <a href="{{route('top')}}">トップに戻る</a>
        </div>
    </div>
</body>
</html>