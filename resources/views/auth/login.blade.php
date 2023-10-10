@extends('layouts.base')
@section('title', 'ログイン画面')
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
<p>ログイン済みですよ</p>
@else
<form action="login" method="post">
    @csrf
    <div>
        <div>
            <label for="{{ConstParams::LOGIN_ID}}">{{ConstParams::LOGIN_ID_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::LOGIN_ID}}" id="{{ConstParams::LOGIN_ID}}" value="{{old(ConstParams::LOGIN_ID)}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::PASSWORD}}">{{ConstParams::PASSWORD_JP}}</label>
        </div>
        <div>
            <input type="password" name="{{ConstParams::PASSWORD}}" id="{{ConstParams::PASSWORD}}">
        </div>
    </div>
    <div>
        <button type="submit">送信</button>
    </div>
</form>
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection