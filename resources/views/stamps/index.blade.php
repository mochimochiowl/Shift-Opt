@extends('layouts.base')
@section('title', '打刻画面')
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
<form action="" method="post">
    @csrf
    <div>
        <label for="target_login_id">{{ConstParams::LOGIN_ID_JP}}</label>
        <input type="text" name="target_login_id" id="target_login_id" value="{{old('target_login_id')}}">
    </div>
    <div>
        <input type="submit" value="{{ConstParams::AT_RECORD_START_WORK_JP}}" formaction="{{route('stamps.startWork')}}" formmethod="POST">
        <input type="submit" value="{{ConstParams::AT_RECORD_FINISH_WORK_JP}}" formaction="{{route('stamps.finishWork')}}" formmethod="POST">
        <input type="submit" value="{{ConstParams::AT_RECORD_START_BREAK_JP}}" formaction="{{route('stamps.startBreak')}}" formmethod="POST">
        <input type="submit" value="{{ConstParams::AT_RECORD_FINISH_BREAK_JP}}" formaction="{{route('stamps.finishBreak')}}" formmethod="POST">
    </div>
</form>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection