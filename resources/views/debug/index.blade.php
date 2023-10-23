@extends('layouts.base')
@section('title', 'デバッグメニュー')
@section('content')
<hr>
<ul>
    <li><a href="{{ route('debug.loginForm') }}">ログインフォーム</a></li>
    <li><a href="{{ route('debug.table') }}">テーブル</a></li>
</ul>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection