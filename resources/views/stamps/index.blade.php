@extends('layouts.base')
@section('title', '打刻画面')
@section('content')
<div class="px-2 py-2 text-4xl font-bold text-center text-black rounded-xl bg-blue-100">
    <span id="realTimer" class="">{{getCurrentTime()}}</span>
</div>
<form action="" method="post" class="px-2 py-2 mt-4 text-4xl font-bold text-center text-black rounded-xl bg-blue-100">
    @csrf
    @component('components.inputText', [
        'type' => 'text',
        'name'=> 'target_login_id',
        'name_jp'=> ConstParams::LOGIN_ID_JP,
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    <div class="pt-4">
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