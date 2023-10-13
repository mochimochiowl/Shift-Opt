@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '編集画面')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if ($record)
<p>{{$record->kanji_last_name}} {{$record->kanji_first_name}}さん の {{$record->at_record_type_jp}}データ</p>
<form action="{{route('at_records.update', [ConstParams::AT_RECORD_ID => $record->at_record_id])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <p>{{ConstParams::AT_RECORD_ID_JP}} : {{$record->at_record_id}}</p>
        <input type="hidden" name="{{ConstParams::AT_RECORD_ID}}" id="{{ConstParams::AT_RECORD_ID}}" value="{{$record->at_record_id}}" readonly>
        <p>{{ConstParams::USER_ID_JP}} : {{$record->user_id}}</p>
        <p>名前 : {{$record->kanji_last_name}} {{$record->kanji_first_name}}</p>
        <p>なまえ : {{$record->kana_last_name}} {{$record->kana_first_name}}</p>
        <div>
            <label for="{{ConstParams::AT_RECORD_TYPE}}">{{ConstParams::AT_RECORD_TYPE_JP}} : </label>
            <select name="{{ConstParams::AT_RECORD_TYPE}}" id="{{ConstParams::AT_RECORD_TYPE}}">
                <option value="{{ConstParams::AT_RECORD_START_WORK}}" 
                        {{ ($record->at_record_type == ConstParams::AT_RECORD_START_WORK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_START_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_WORK}}" 
                        {{ ($record->at_record_type == ConstParams::AT_RECORD_FINISH_WORK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_FINISH_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_START_BREAK}}" 
                        {{ ($record->at_record_type == ConstParams::AT_RECORD_START_BREAK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_START_BREAK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_BREAK}}" 
                        {{ ($record->at_record_type == ConstParams::AT_RECORD_FINISH_BREAK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_FINISH_BREAK_JP}}
                </option>
            </select>
        </div>
        <div>
            <label for="at_record_time_date">日付 : </label>
            <input type="date" name="at_record_time_date" id="at_record_time_date" value="{{ explode(' ', $record->at_record_time)[0] }}">
        </div>
        <div>
            <label for="at_record_time_time">時刻 : </label>
            <input type="time" name="at_record_time_time" id="at_record_time_time" value="{{ explode(' ', $record->at_record_time)[1] }}">
        </div>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$record->created_at}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$record->updated_at}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$record->created_by}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$record->updated_by}}</p>
    </div>
    <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
    <div><input type="submit" value="更新"></div>
</form>
@else
    <p>更新に失敗</p>
@endif
<hr>
<div>
    @if ($record)
    <form action="{{route('at_records.delete.confirm', [ConstParams::AT_RECORD_ID => $record->at_record_id])}}" method="POST">
        @csrf
        <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
        <button type="submit">この{{ConstParams::AT_RECORD_JP}}を削除する</button>
    </form>
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection