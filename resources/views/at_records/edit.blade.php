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
@if ($data)
<form action="{{route('at_records.update', [ConstParams::AT_RECORD_ID => $data[ConstParams::AT_RECORD_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <p>{{ConstParams::AT_RECORD_ID_JP}} : {{$data[ConstParams::AT_RECORD_ID]}}</p>
        <p>{{ConstParams::AT_SESSION_ID_JP}} : {{$data[ConstParams::AT_SESSION_ID]}}</p>
        <input type="hidden" name="{{ConstParams::AT_RECORD_ID}}" id="{{ConstParams::AT_RECORD_ID}}" value="{{$data[ConstParams::AT_RECORD_ID]}}" readonly>
        <p>{{ConstParams::USER_ID_JP}} : {{$data[ConstParams::USER_ID]}}</p>
        <p>名前 : {{$data[ConstParams::KANJI_LAST_NAME]}} {{$data[ConstParams::KANJI_FIRST_NAME]}}</p>
        <p>なまえ : {{$data[ConstParams::KANA_LAST_NAME]}} {{$data[ConstParams::KANA_FIRST_NAME]}}</p>
        <div>
            <label for="{{ConstParams::AT_RECORD_TYPE}}">{{ConstParams::AT_RECORD_TYPE_JP}} : </label>
            <select name="{{ConstParams::AT_RECORD_TYPE}}" id="{{ConstParams::AT_RECORD_TYPE}}">
                <option value="{{ConstParams::AT_RECORD_START_WORK}}" 
                        {{ ($data->at_record_type == ConstParams::AT_RECORD_START_WORK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_START_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_WORK}}" 
                        {{ ($data->at_record_type == ConstParams::AT_RECORD_FINISH_WORK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_FINISH_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_START_BREAK}}" 
                        {{ ($data->at_record_type == ConstParams::AT_RECORD_START_BREAK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_START_BREAK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_BREAK}}" 
                        {{ ($data->at_record_type == ConstParams::AT_RECORD_FINISH_BREAK) ? 'selected' : '' }}>
                    {{ConstParams::AT_RECORD_FINISH_BREAK_JP}}
                </option>
            </select>
        </div>
        <div>
            <label for="{{ConstParams::AT_RECORD_DATE}}">{{ConstParams::AT_RECORD_DATE_JP}} : </label>
            <input type="date" name="{{ConstParams::AT_RECORD_DATE}}" id="{{ConstParams::AT_RECORD_DATE}}" value="{{$data[ConstParams::AT_RECORD_DATE]}}">
        </div>
        <div>
            <label for="{{ConstParams::AT_RECORD_TIME}}">{{ConstParams::AT_RECORD_TIME_JP}} : </label>
            <input type="time" name="{{ConstParams::AT_RECORD_TIME}}" id="{{ConstParams::AT_RECORD_TIME}}" value="{{$data[ConstParams::AT_RECORD_TIME]}}">
        </div>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$data[ConstParams::CREATED_AT]}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$data[ConstParams::UPDATED_AT]}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$data[ConstParams::CREATED_BY]}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$data[ConstParams::UPDATED_BY]}}</p>
    </div>
    <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
    <div><input type="submit" value="更新"></div>
</form>
@else
    <p>更新に失敗</p>
@endif
<hr>
<div>
    @if ($data)
    <form action="{{route('at_records.delete.confirm', [ConstParams::AT_RECORD_ID => $data[ConstParams::AT_RECORD_ID]])}}" method="POST">
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