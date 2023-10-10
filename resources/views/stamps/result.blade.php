@extends('layouts.base')
@section('title', '打刻処理成功画面')
@section('content')
<div>
    <p>処理に成功しました。</p>
    <p>入力されたデータ</p>
    <p>{{ConstParams::LOGIN_ID_JP}} : {{$user->login_id}}</p>
    <p>{{ConstParams::KANJI_LAST_NAME_JP}} : {{$user->kanji_last_name}}</p>
    <p>{{ConstParams::KANJI_FIRST_NAME_JP}} : {{$user->kanji_first_name}}</p>
    <p>{{ConstParams::AT_RECORD_TYPE_JP}} : {{$type}}</p>
    <p>{{ConstParams::AT_RECORD_TIME_JP}} : {{$time}}</p>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection