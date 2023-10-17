@extends('layouts.base')
@section('title', 'トップ画面')
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
    @if (Auth::check())
    <p>{{Auth::user()->getKanjiFullName()}}さん、こんにちは</p>
    @else
    <p>ログインしていません</p>
    @endif
    @component('components.dailySummary', ['data'=> ['date' => $date]])
    @endcomponent
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection