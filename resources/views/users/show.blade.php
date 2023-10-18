@extends('layouts.base')
@section('title', ConstParams::USER_JP . '情報詳細画面')
@section('content')
<div>
    <button type="button" onclick="movePreviousPage()">戻る</button>
    <h2>{{ConstParams::USER_JP}}</h2>
    <a href="{{route('users.edit', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}">編集</a>
    @component('components.userInfo', ['user_data'=> $user_data])
    @endcomponent
    <h2>{{ConstParams::USER_SALARY_JP}}</h2>
    <a href="{{route('users.salaries.edit', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}">編集</a>
    @component('components.userSalaryInfo', ['salary_data'=> $salary_data])
    @endcomponent    
    <h2>{{ConstParams::USER_CONDITION_JP}}</h2>
    <a href="{{route('users.conditions.edit', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}">編集</a>
    @component('components.userConditionInfo', ['condition_data'=> $condition_data])
    @endcomponent
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection