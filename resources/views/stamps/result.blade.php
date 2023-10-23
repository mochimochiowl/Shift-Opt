@extends('layouts.base')
@section('title', '打刻処理結果（' . ConstParams::AT_RECORD_TYPE_JP .'）')
@section('content')
@component('components.h2',['title' => ConstParams::USER_JP])
@endcomponent
@component('components.link', [
    'href'=> route('stamps.index'),
    'label'=> '戻る',
])
@endcomponent
<div class="p-4 my-4 text-2xl rounded-xl bg-blue-200">
    <div>
        <span>{{ConstParams::USER_ID_JP}} :</span><span>{{$login_id}}</span>
    </div>
    <div>
        <span>名前 :</span><span>{{$name}}</span>
    </div>
    <div>
        <span>{{ConstParams::AT_RECORD_TYPE_JP}} :</span><span>{{$type}}</span>
    </div>
    <div>
        <span>{{ConstParams::AT_RECORD_DATE_JP}} :</span><span>{{$date}}</span>
    </div>
    <div>
        <span>{{ConstParams::AT_RECORD_TIME_JP}} :</span><span>{{$time}}</span>
    </div>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection