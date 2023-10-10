@extends('layouts.base')
@section('title', 'トップ画面')
@section('content')
    @if (Auth::check())
    <p>{{Auth::user()->kanji_last_name . Auth::user()->kanji_first_name}}さん、こんにちは</p>
    @else
    <p>ログインしていません</p>
    @endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection