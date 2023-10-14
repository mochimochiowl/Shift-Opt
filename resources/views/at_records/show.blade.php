@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '情報詳細画面')
@section('content')
@component('components.atRecordShow', ['data' => $data])
@endcomponent
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection