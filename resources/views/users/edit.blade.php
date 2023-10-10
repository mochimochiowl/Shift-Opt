@extends('layouts.base')
@section('title', 'ユーザー情報編集画面')
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
@if ($user)
<p>{{$user->kanji_last_name . $user->kanji_first_name}}さん の データ</p>
<form action="{{route('users.update', [ConstParams::USER_ID => $user->user_id])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <div>
            <label for="{{ConstParams::USER_ID}}">{{ConstParams::USER_ID_JP}} ＊この項目は変更できません。</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::USER_ID}}" id="{{ConstParams::USER_ID}}" value="{{$user->user_id}}" readonly>
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::KANJI_LAST_NAME}}">{{ConstParams::KANJI_LAST_NAME_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::KANJI_LAST_NAME}}" id="{{ConstParams::KANJI_LAST_NAME}}" value="{{$user->kanji_last_name}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::KANJI_FIRST_NAME}}">{{ConstParams::KANJI_FIRST_NAME_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::KANJI_FIRST_NAME}}" id="{{ConstParams::KANJI_FIRST_NAME}}" value="{{$user->kanji_first_name}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::KANA_LAST_NAME}}">{{ConstParams::KANA_LAST_NAME_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::KANA_LAST_NAME}}" id="{{ConstParams::KANA_LAST_NAME}}" value="{{$user->kana_last_name}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::KANA_FIRST_NAME}}">{{ConstParams::KANA_FIRST_NAME_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::KANA_FIRST_NAME}}" id="{{ConstParams::KANA_FIRST_NAME}}" value="{{$user->kana_first_name}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::EMAIL}}">{{ConstParams::EMAIL_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::EMAIL}}" id="{{ConstParams::EMAIL}}" value="{{$user->email}}">
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::EMAIL_VERIFIED_AT}}">{{ConstParams::EMAIL_VERIFIED_AT_JP}} ＊この項目は変更できません。</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::EMAIL_VERIFIED_AT}}" id="{{ConstParams::EMAIL_VERIFIED_AT}}" value="{{$user->email_verified_at}}" readonly>
        </div>
    </div>
    <div>
        <div>
            <label for="{{ConstParams::LOGIN_ID}}">{{ConstParams::LOGIN_ID_JP}}</label>
        </div>
        <div>
            <input type="text" name="{{ConstParams::LOGIN_ID}}" id="{{ConstParams::LOGIN_ID}}" value="{{$user->login_id}}">
        </div>
    </div>
    <div>
        <div>
            <p>{{ConstParams::PASSWORD_JP}}はここでは変更できません。</p>
        </div>
    </div>
    <div>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$user->created_at}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$user->updated_at}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$user->created_by}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$user->updated_by}}</p>
    </div>
    <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
    <div><input type="submit" value="更新"></div>
</form>
@else
    <p>更新に失敗</p>
@endif
<hr>
<div>
    @if ($user)
    <form action="{{route('users.delete.confirm', [ConstParams::USER_ID => $user->user_id])}}" method="POST">
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