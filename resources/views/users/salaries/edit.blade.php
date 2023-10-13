@extends('layouts.base')
@section('title', ConstParams::USER_SALARY_JP . '編集画面')
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
@if ($user_data && $salary_data)
<form action="{{route('users.salaries.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <p>{{ConstParams::USER_ID_JP}} : {{$user_data[ConstParams::USER_ID]}}</p>
        <p>名前 : {{$user_data[ConstParams::KANJI_LAST_NAME]}} {{$user_data[ConstParams::KANJI_FIRST_NAME]}}</p>
        <p>なまえ : {{$user_data[ConstParams::KANA_LAST_NAME]}} {{$user_data[ConstParams::KANA_FIRST_NAME]}}</p>
        <div>
            <label for="{{ConstParams::HOURLY_WAGE}}">{{ConstParams::HOURLY_WAGE_JP}}</label>
            <input type="text" name="{{ConstParams::HOURLY_WAGE}}" id="{{ConstParams::HOURLY_WAGE}}" value="{{$salary_data[ConstParams::HOURLY_WAGE]}}">
        </div>
        <p>{{ConstParams::CREATED_AT_JP}} : {{$salary_data[ConstParams::CREATED_AT]}}</p>
        <p>{{ConstParams::UPDATED_AT_JP}} : {{$salary_data[ConstParams::UPDATED_AT]}}</p>
        <p>{{ConstParams::CREATED_BY_JP}} : {{$salary_data[ConstParams::CREATED_BY]}}</p>
        <p>{{ConstParams::UPDATED_BY_JP}} : {{$salary_data[ConstParams::UPDATED_BY]}}</p>
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