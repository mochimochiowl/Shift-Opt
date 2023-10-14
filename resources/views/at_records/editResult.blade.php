@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '情報更新処理成功画面')
@section('content')
<div>
    @if ($count === 0)
    <p>データが更新できませんでした。</p>
    @else
    @component('components.atRecordShow', ['data' => $data])
    @endcomponent
    @endif
</div>
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection