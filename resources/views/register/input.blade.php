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
    @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message') }}
        </div>
    @endif
    <a href="/">トップ画面に戻る</a>
    <form action="" method="post">
        @csrf
        <div>
            <div>
                <label for="kanji_last_name">{{ConstParams::KANJI_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="kanji_last_name" id="kanji_last_name">
            </div>
        </div>
        <div>
            <div>
                <label for="kanji_first_name">{{ConstParams::KANJI_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="kanji_first_name" id="kanji_first_name">
            </div>
        </div>
        <div>
            <div>
                <label for="kana_last_name">{{ConstParams::KANA_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="kana_last_name" id="kana_last_name">
            </div>
        </div>
        <div>
            <div>
                <label for="kana_first_name">{{ConstParams::KANA_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="kana_first_name" id="kana_first_name">
            </div>
        </div>
        <div>
            <div>
                <label for="email">{{ConstParams::EMAIL_JP}}</label>
            </div>
            <div>
                <input type="email" name="email" id="email">
            </div>
        </div>
        <div>
            <div>
                <label for="login_id">{{ConstParams::LOGIN_ID_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="text" name="login_id" id="login_id">
            </div>
        </div>
        <div>
            <div>
                <label for="password">{{ConstParams::PASSWORD_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="password" name="password" id="password">
            </div>
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
    </form>
</body>