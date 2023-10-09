<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スタッフ登録画面</title>
</head>
<body>
    <h1>スタッフ登録画面</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route('users.store')}}" method="post">
        @csrf
        <div>
            <div>
                <label for="{{ConstParams::KANJI_LAST_NAME}}">{{ConstParams::KANJI_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANJI_LAST_NAME}}" id="{{ConstParams::KANJI_LAST_NAME}}" value="{{old(ConstParams::KANJI_LAST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANJI_FIRST_NAME}}">{{ConstParams::KANJI_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANJI_FIRST_NAME}}" id="{{ConstParams::KANJI_FIRST_NAME}}" value="{{old(ConstParams::KANJI_FIRST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANA_LAST_NAME}}">{{ConstParams::KANA_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANA_LAST_NAME}}" id="{{ConstParams::KANA_LAST_NAME}}" value="{{old(ConstParams::KANA_LAST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANA_FIRST_NAME}}">{{ConstParams::KANA_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANA_FIRST_NAME}}" id="{{ConstParams::KANA_FIRST_NAME}}" value="{{old(ConstParams::KANA_FIRST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::EMAIL}}">{{ConstParams::EMAIL_JP}}</label>
            </div>
            <div>
                <input type="email" name="{{ConstParams::EMAIL}}" id="{{ConstParams::EMAIL}}" value="{{old(ConstParams::EMAIL)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::LOGIN_ID}}">{{ConstParams::LOGIN_ID_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::LOGIN_ID}}" id="{{ConstParams::LOGIN_ID}}" value="{{old(ConstParams::LOGIN_ID)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::PASSWORD}}">{{ConstParams::PASSWORD_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="password" name="{{ConstParams::PASSWORD}}" id="{{ConstParams::PASSWORD}}">
            </div>
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
    </form>
    <div>
        <a href="{{route('top')}}">トップに戻る</a>
    </div>
</body>