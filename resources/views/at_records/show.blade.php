@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '情報詳細画面')
@section('content')
<div>
    <p>{{ConstParams::AT_RECORD_ID_JP}} : {{$data[ConstParams::AT_RECORD_ID]}}</p>
    <p>{{ConstParams::USER_ID_JP}} : {{$data[ConstParams::USER_ID]}}</p>
    <p>名前 : {{$data[ConstParams::KANJI_LAST_NAME]}} {{$data[ConstParams::KANJI_FIRST_NAME]}}</p>
    <p>なまえ : {{$data[ConstParams::KANA_LAST_NAME]}} {{$data[ConstParams::KANA_FIRST_NAME]}}</p>
    <p>{{ConstParams::AT_RECORD_TYPE_JP}} : {{$data[ConstParams::AT_RECORD_TYPE]}}</p>
    <p>{{ConstParams::AT_RECORD_DATE_JP}} : {{$data[ConstParams::AT_RECORD_DATE]}}</p>
    <p>{{ConstParams::AT_RECORD_TIME_JP}} : {{$data[ConstParams::AT_RECORD_TIME]}}</p>
    <p>{{ConstParams::CREATED_AT_JP}} : {{$data[ConstParams::CREATED_AT]}}</p>
    <p>{{ConstParams::UPDATED_AT_JP}} : {{$data[ConstParams::UPDATED_AT]}}</p>
    <p>{{ConstParams::CREATED_BY_JP}} : {{$data[ConstParams::CREATED_BY]}}</p>
    <p>{{ConstParams::UPDATED_BY_JP}} : {{$data[ConstParams::UPDATED_BY]}}</p>
</div>
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection