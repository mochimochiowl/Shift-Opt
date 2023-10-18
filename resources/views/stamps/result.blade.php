@extends('layouts.base')
@section('title', '打刻処理成功画面')
@section('content')
<div>
    <button type="button" onclick="movePreviousPage()">戻る</button>
    <p>処理に成功しました。</p>
    <p>入力されたデータ</p>
    <p>{{ConstParams::LOGIN_ID_JP}} : {{$login_id}}</p>
    <p>名前 : {{$name}}</p>
    <p>{{ConstParams::AT_RECORD_TYPE_JP}} : {{$type}}</p>
    <p>{{ConstParams::AT_RECORD_DATE_JP}} : {{$date}}</p>
    <p>{{ConstParams::AT_RECORD_TIME_JP}} : {{$time}}</p>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection