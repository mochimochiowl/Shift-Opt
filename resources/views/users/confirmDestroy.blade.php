<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー削除（確認）</title>
</head>

<body>
    <h1>ユーザー削除確認画面</h1>
    @if ($user->user_id === 1)
    <p>管理者ユーザーは削除できません。</p>
    @else
    <div>
        <p>{{$user->kanji_last_name . $user->kanji_first_name}}さん の データを削除します。</p>
        <p>データを一度削除すると、戻すことはできません。</p>
        <p>【削除対象のデータ詳細】</p>
        <p>{{ConstParams::USER_ID_JP}} : {{$user->user_id}}</p>
        <p>{{ConstParams::KANJI_LAST_NAME_JP}} : {{$user->kanji_last_name}}</p>
        <p>{{ConstParams::KANJI_FIRST_NAME_JP}} : {{$user->kanji_first_name}}</p>
        <p>{{ConstParams::KANA_LAST_NAME_JP}} : {{$user->kana_last_name}}</p>
        <p>{{ConstParams::KANA_FIRST_NAME_JP}} : {{$user->kana_first_name}}</p>
        <p>{{ConstParams::EMAIL_JP}} : {{$user->email}}</p>
        <p>{{ConstParams::EMAIL_VERIFIED_AT_JP}} : {{$user->email_verified_at}}</p>
        <p>{{ConstParams::LOGIN_ID_JP}} : {{$user->login_id}}</p>
        <p>{{ConstParams::PASSWORD_JP}} : 非公開</p>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$user->created_at}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$user->updated_at}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$user->created_by}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$user->updated_by}}</p>
    </div>
    <div>
        <p>本当に削除してもよろしいですか？</p>
        <form action="{{route('users.delete', [ConstParams::USER_ID => $user->user_id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">このユーザーを削除する</button>
        </form>
    </div>
    @endif
    <div>
        <a href="{{route('users.search')}}">ユーザー検索画面に戻る</a>
    </div>
    <div>
        <a href="{{route('top')}}">トップに戻る</a>
    </div>
</body>

</html>