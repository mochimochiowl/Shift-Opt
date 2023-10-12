@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '情報詳細画面')
@section('content')
<div>
    <p>{{ConstParams::AT_RECORD_ID_JP}} : {{$record['at_record_id']}}</p>
    <p>{{ConstParams::USER_ID_JP}} : {{$record['user_id']}}</p>
    <p>名前 : {{$record['user_kanji_name']}}</p>
    <p>なまえ : {{$record['user_kana_name']}}</p>
    <p>{{ConstParams::AT_RECORD_TYPE_JP}} : {{$record['at_record_type']}}</p>
    <p>{{ConstParams::AT_RECORD_TIME_JP}} : {{$record['at_record_time']}}</p>
    <p>{{ConstParams::CREATED_AT_JP}} : {{$record['created_at']}}</p>
    <p>{{ConstParams::UPDATED_AT_JP}} : {{$record['updated_at']}}</p>
    <p>{{ConstParams::CREATED_BY_JP}} : {{$record['created_by']}}</p>
    <p>{{ConstParams::UPDATED_BY_JP}} : {{$record['updated_by']}}</p>
</div>
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection