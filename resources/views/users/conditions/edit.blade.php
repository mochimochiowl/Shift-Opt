@extends('layouts.base')
@section('title', ConstParams::USER_CONDITION_JP . '編集画面')
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
@if ($user_data && $condition_data)
<form action="{{route('users.conditions.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <p>{{ConstParams::USER_ID_JP}} : {{$user_data[ConstParams::USER_ID]}}</p>
        <p>名前 : {{$user_data[ConstParams::KANJI_LAST_NAME]}} {{$user_data[ConstParams::KANJI_FIRST_NAME]}}</p>
        <p>なまえ : {{$user_data[ConstParams::KANA_LAST_NAME]}} {{$user_data[ConstParams::KANA_FIRST_NAME]}}</p>
        <div>
            <label for="{{ConstParams::HAS_ATTENDED}}">{{ConstParams::HAS_ATTENDED_JP}}</label>
            <select name="{{ConstParams::HAS_ATTENDED}}" id="{{ConstParams::HAS_ATTENDED}}">
                <option value="1" {{ $condition_data[ConstParams::HAS_ATTENDED] ? 'selected' : '' }}>{{ConstParams::HAS_ATTENDED_TRUE_JP}}</option>
                <option value="0" {{ !$condition_data[ConstParams::HAS_ATTENDED] ? 'selected' : '' }}>{{ConstParams::HAS_ATTENDED_FALSE_JP}}</option>
            </select>
        </div>
        <div>
            <label for="{{ConstParams::IS_BREAKING}}">{{ConstParams::IS_BREAKING_JP}}</label>
            <select name="{{ConstParams::IS_BREAKING}}" id="{{ConstParams::IS_BREAKING}}">
                <option value="1" {{ $condition_data[ConstParams::IS_BREAKING] ? 'selected' : '' }}>{{ConstParams::IS_BREAKING_TRUE_JP}}</option>
                <option value="0" {{ !$condition_data[ConstParams::IS_BREAKING] ? 'selected' : '' }}>{{ConstParams::IS_BREAKING_FALSE_JP}}</option>
            </select>
        </div>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$condition_data[ConstParams::CREATED_AT]}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$condition_data[ConstParams::UPDATED_AT]}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$condition_data[ConstParams::CREATED_BY]}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$condition_data[ConstParams::UPDATED_BY]}}</p>
    </div>
    <div><input type="submit" value="更新"></div>
</form>
@else
    <p>更新に失敗</p>
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection