@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '削除確認画面')
@section('content')
<div>
    <p>以下のデータを削除します。</p>
    <p>データを一度削除すると、戻すことはできません。</p>
    <p>【削除対象のデータ詳細】</p>
    <p>{{ConstParams::AT_RECORD_ID_JP}} : {{$record['at_record_id']}}</p>
    <p>{{ConstParams::USER_ID_JP}} : {{$record['user_id']}}</p>
    <p>名前 : {{$record['kanji_last_name']}} {{$record['kanji_first_name']}}</p>
    <p>なまえ : {{$record['kana_last_name']}} {{$record['kana_first_name']}}</p>
    <p>{{ConstParams::AT_RECORD_TYPE_JP}} : {{$record['at_record_type_jp']}}</p>
    <p>{{ConstParams::AT_RECORD_TIME_JP}} : {{$record['at_record_time']}}</p>
    <p>{{ConstParams::CREATED_AT_JP}} : {{$record['created_at']}}</p>
    <p>{{ConstParams::UPDATED_AT_JP}} : {{$record['updated_at']}}</p>
    <p>{{ConstParams::CREATED_BY_JP}} : {{$record['created_by']}}</p>
    <p>{{ConstParams::UPDATED_BY_JP}} : {{$record['updated_by']}}</p>
</div>
<div>
    <p>本当に削除してもよろしいですか？</p>
    <form action="{{route('at_records.delete', [ConstParams::AT_RECORD_ID => $record->at_record_id])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">この{{ConstParams::AT_RECORD_JP}}を削除する</button>
    </form>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection