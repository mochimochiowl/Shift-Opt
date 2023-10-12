@extends('layouts.base')
@section('title', 'スタッフ登録画面')
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
    <form action="{{route('users.store')}}" method="post">
        @csrf
        <div>
            <div>
                <label for="{{ConstParams::KANJI_LAST_NAME}}">{{ConstParams::KANJI_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANJI_LAST_NAME}}" id="{{ConstParams::KANJI_LAST_NAME}}" value="{{old(ConstParams::KANJI_LAST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANJI_FIRST_NAME}}">{{ConstParams::KANJI_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANJI_FIRST_NAME}}" id="{{ConstParams::KANJI_FIRST_NAME}}" value="{{old(ConstParams::KANJI_FIRST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANA_LAST_NAME}}">{{ConstParams::KANA_LAST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANA_LAST_NAME}}" id="{{ConstParams::KANA_LAST_NAME}}" value="{{old(ConstParams::KANA_LAST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::KANA_FIRST_NAME}}">{{ConstParams::KANA_FIRST_NAME_JP}}（15文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::KANA_FIRST_NAME}}" id="{{ConstParams::KANA_FIRST_NAME}}" value="{{old(ConstParams::KANA_FIRST_NAME)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::EMAIL}}">{{ConstParams::EMAIL_JP}}</label>
            </div>
            <div>
                <input type="email" name="{{ConstParams::EMAIL}}" id="{{ConstParams::EMAIL}}" value="{{old(ConstParams::EMAIL)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::LOGIN_ID}}">{{ConstParams::LOGIN_ID_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="text" name="{{ConstParams::LOGIN_ID}}" id="{{ConstParams::LOGIN_ID}}" value="{{old(ConstParams::LOGIN_ID)}}">
            </div>
        </div>
        <div>
            <div>
                <label for="{{ConstParams::PASSWORD}}">{{ConstParams::PASSWORD_JP}}（20文字以内）</label>
            </div>
            <div>
                <input type="password" name="{{ConstParams::PASSWORD}}" id="{{ConstParams::PASSWORD}}">
            </div>
        </div>
        <div>
            <button type="submit">送信</button>
        </div>
    </form>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection