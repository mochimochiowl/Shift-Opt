@extends('layouts.base')
@section('title', 'ユーザー情報詳細画面')
@section('content')
<div>
    <p>{{$user->kanji_last_name . $user->kanji_first_name}}さん の データ</p>
    <p>{{ConstParams::USER_ID_JP}} : {{$user->user_id}}</p>
    <p>{{ConstParams::KANJI_LAST_NAME_JP}} : {{$user->kanji_last_name}}</p>
    <p>{{ConstParams::KANJI_FIRST_NAME_JP}} : {{$user->kanji_first_name}}</p>
    <p>{{ConstParams::KANA_LAST_NAME_JP}} : {{$user->kana_last_name}}</p>
    <p>{{ConstParams::KANA_FIRST_NAME_JP}} : {{$user->kana_first_name}}</p>
    <p>{{ConstParams::EMAIL_JP}} : {{$user->email}}</p>
    <p>{{ConstParams::EMAIL_VERIFIED_AT_JP}} : {{$user->email_verified_at}}</p>
    <p>{{ConstParams::LOGIN_ID_JP}} : {{$user->login_id}}</p>
    <p>{{ConstParams::PASSWORD_JP}}(ハッシュ処理済) : {{$user->password}}</p>
    <p>{{ConstParams::CREATED_AT_JP}} : {{$user->created_at}}</p>
    <p>{{ConstParams::UPDATED_AT_JP}} : {{$user->updated_at}}</p>
    <p>{{ConstParams::CREATED_BY_JP}} : {{$user->created_by}}</p>
    <p>{{ConstParams::UPDATED_BY_JP}} : {{$user->updated_by}}</p>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection