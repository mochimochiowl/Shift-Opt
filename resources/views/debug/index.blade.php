@extends('layouts.base')
@section('title', 'デバッグメニュー')
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
<hr>
<ul>
    <li><a href="{{ route('debug.loginForm') }}">ログインフォーム</a></li>
    <li><a href="{{ route('debug.table') }}">テーブル</a></li>
</ul>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection