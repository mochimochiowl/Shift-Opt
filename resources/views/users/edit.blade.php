@extends('layouts.base')
@section('title', ConstParams::USER_JP . '編集画面')
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
@if ($user_data)
<form action="{{route('users.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <span>{{ConstParams::USER_ID_JP}} : {{$user_data[ConstParams::USER_ID]}}</span>
    </div>
    <div>
        <label for="{{ConstParams::KANJI_LAST_NAME}}">{{ConstParams::KANJI_LAST_NAME_JP}} : </label>
        <input type="text" name="{{ConstParams::KANJI_LAST_NAME}}" id="{{ConstParams::KANJI_LAST_NAME}}" value="{{$user_data[ConstParams::KANJI_LAST_NAME]}}">
    </div>
    <div>
        <label for="{{ConstParams::KANJI_FIRST_NAME}}">{{ConstParams::KANJI_FIRST_NAME_JP}} : </label>
        <input type="text" name="{{ConstParams::KANJI_FIRST_NAME}}" id="{{ConstParams::KANJI_FIRST_NAME}}" value="{{$user_data[ConstParams::KANJI_FIRST_NAME]}}">
    </div>
    <div>
        <label for="{{ConstParams::KANA_LAST_NAME}}">{{ConstParams::KANA_LAST_NAME_JP}} : </label>
        <input type="text" name="{{ConstParams::KANA_LAST_NAME}}" id="{{ConstParams::KANA_LAST_NAME}}" value="{{$user_data[ConstParams::KANA_LAST_NAME]}}">
    </div>
    <div>
        <label for="{{ConstParams::KANA_FIRST_NAME}}">{{ConstParams::KANA_FIRST_NAME_JP}} : </label>
        <input type="text" name="{{ConstParams::KANA_FIRST_NAME}}" id="{{ConstParams::KANA_FIRST_NAME}}" value="{{$user_data[ConstParams::KANA_FIRST_NAME]}}">
    </div>
    <div>
        <label for="{{ConstParams::EMAIL}}">{{ConstParams::EMAIL_JP}} : </label>
        <input type="text" name="{{ConstParams::EMAIL}}" id="{{ConstParams::EMAIL}}" value="{{$user_data[ConstParams::EMAIL]}}">
    </div>
    <div>
        <span>{{ConstParams::EMAIL_VERIFIED_AT_JP}} : {{$user_data[ConstParams::EMAIL_VERIFIED_AT] ?? '未認証'}}</span>
    </div>
    <div>
        <label for="{{ConstParams::LOGIN_ID}}">{{ConstParams::LOGIN_ID_JP}} : </label>
        <input type="text" name="{{ConstParams::LOGIN_ID}}" id="{{ConstParams::LOGIN_ID}}" value="{{$user_data[ConstParams::LOGIN_ID]}}">
    </div>
    <div>
        <span>{{ConstParams::PASSWORD_JP}}はここでは変更できません。</span>
    </div>
    <div>
        <span>{{ConstParams::CREATED_AT_JP}} : {{$user_data[ConstParams::CREATED_AT]}}</span>
    </div>
    <div>
        <span>{{ConstParams::UPDATED_AT_JP}} : {{$user_data[ConstParams::UPDATED_AT]}}</span>
    </div>
    <div>
        <span>{{ConstParams::CREATED_BY_JP}} : {{$user_data[ConstParams::CREATED_BY]}}</span>
    </div>
    <div>
        <span>{{ConstParams::UPDATED_BY_JP}} : {{$user_data[ConstParams::UPDATED_BY]}}</span>
    </div>
    <div>
        <input type="submit" value="更新">
    </div>
</form>
@else
    <p>更新に失敗</p>
@endif
<hr>
<div>
    @if ($user_data)
    <form action="{{route('users.delete.confirm', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
        @csrf
        <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
        <button type="submit">このユーザーを削除する</button>
    </form>
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection