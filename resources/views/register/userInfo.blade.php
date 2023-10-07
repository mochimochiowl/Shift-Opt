<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ユーザー情報</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="{{asset('resources/js/currentTimer.js')}}"></script>
</head>

<body>
    <h1>User Information</h1>
    <div>
        <p>{{$user->kanji_last_name . $user->kanji_first_name}}さん の データ</p>
        <p>user_id : {{$user->user_id}}</p>
        <p>kanji_last_name : {{$user->kanji_last_name}}</p>
        <p>kanji_first_name : {{$user->kanji_first_name}}</p>
        <p>kana_last_name : {{$user->kana_last_name}}</p>
        <p>kana_first_name : {{$user->kana_first_name}}</p>
        <p>email : {{$user->email}}</p>
        <p>email_verified_at : {{$user->email_verified_at}}</p>
        <p>login_id : {{$user->login_id}}</p>
        <p>password(ハッシュ処理済) : {{$user->password}}</p>
        <p>creation_time : {{$user->created_at}}</p>
        <p>update_time : {{$user->updated_at}}</p>
        <p>created_by : {{$user->created_by}}</p>
        <p>updated_by : {{$user->updated_by}}</p>
    </div>
    <div>
        <a href="/">トップに戻る</a>
    </div>
    <div>
        <form action="logout" method="post">
            <button>ログアウトする</button>
        </form>
    </div>
</body>

</html>