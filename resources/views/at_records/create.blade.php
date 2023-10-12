@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '登録画面')
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
    <form action="{{route('at_records.store')}}" method="post">
        @csrf
        <div>
            <div>
                <label for="target_login_id">{{ConstParams::LOGIN_ID_JP}}</label>
                <input type="text" name="target_login_id" id="target_login_id" value="{{old('target_login_id')}}">
            </div>
        </div>
        <div>
            <label for="{{ConstParams::AT_RECORD_TYPE}}">{{ConstParams::AT_RECORD_TYPE_JP}} : </label>
            <select name="{{ConstParams::AT_RECORD_TYPE}}" id="{{ConstParams::AT_RECORD_TYPE}}">
                <option value="{{ConstParams::AT_RECORD_START_WORK}}">
                    {{ConstParams::AT_RECORD_START_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_WORK}}">
                    {{ConstParams::AT_RECORD_FINISH_WORK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_START_BREAK}}">
                    {{ConstParams::AT_RECORD_START_BREAK_JP}}
                </option>
        
                <option value="{{ConstParams::AT_RECORD_FINISH_BREAK}}">
                    {{ConstParams::AT_RECORD_FINISH_BREAK_JP}}
                </option>
            </select>
        </div>
        <div>
            <label for="at_record_time_date">日付 : </label>
            <input type="date" name="at_record_time_date" id="at_record_time_date" value="{{old('at_record_time_date')}}">
        </div>
        <div>
            <label for="at_record_time_time">時刻 : </label>
            <input type="time" name="at_record_time_time" id="at_record_time_time" value="{{old('at_record_time_time')}}">
        </div>
        <input type="hidden" name="created_by_user_id" value="{{Auth::user()->user_id}}">
        <input type="hidden" name="is_admin" value="true">
        <div>
            <button type="submit">送信</button>
        </div>
    </form>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection