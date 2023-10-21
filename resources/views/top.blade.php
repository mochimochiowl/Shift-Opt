@extends('layouts.base')
@section('title', 'トップ画面')
@section('content')
    @if (Auth::check())
    <p>{{Auth::user()->getKanjiFullName()}}さん、こんにちは</p>
    @else
    <p>ログインしていません</p>
    @endif
    <h2>H２タグ</h2>
    <div>
        <p>コンテンツ</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est debitis nostrum similique officiis, amet laboriosam facilis iste! Laborum molestiae odio quis, autem temporibus consequatur facere beatae nemo sapiente enim sed!</p>
    </div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection