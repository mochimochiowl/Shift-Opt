<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン画面</title>
</head>
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h1>ログイン画面</h1>
    @if (Auth::check())
    <p>ログイン済みですよ</p>
    @else
    <form action="login" method="post">
        @csrf
        <div>
            <div>
                <label for="login_id">{{ConstParams::LOGIN_ID_JP}}</label>
            </div>
            <div>
                <input type="text" name="login_id" id="login_id">
            </div>
        </div>
        <div>
            <div>
                <label for="password">{{ConstParams::PASSWORD_JP}}</label>
            </div>
            <div>
                <input type="password" name="password" id="password">
            </div>
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
    </form>
    @endif
    <div>
        <a href="{{route('top')}}">トップに戻る</a>
    </div>
</body>