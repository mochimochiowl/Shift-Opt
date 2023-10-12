@extends('layouts.base')
@section('title', ConstParams::USER_JP . '情報詳細画面')
@section('content')
<div>
    <h2>{{ConstParams::USER_JP}}</h2>
    <table border="1">
        <tr>
            <td>{{ConstParams::USER_ID_JP}}</td>
            <td>{{$user[ConstParams::USER_ID]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::KANJI_LAST_NAME_JP}}</td>
            <td>{{$user[ConstParams::KANJI_LAST_NAME]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::KANJI_FIRST_NAME_JP}}</td>
            <td>{{$user[ConstParams::KANJI_FIRST_NAME]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::KANA_LAST_NAME_JP}}</td>
            <td>{{$user[ConstParams::KANA_LAST_NAME]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::KANA_FIRST_NAME_JP}}</td>
            <td>{{$user[ConstParams::KANA_FIRST_NAME]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::EMAIL_JP}}</td>
            <td>{{$user[ConstParams::EMAIL]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::EMAIL_VERIFIED_AT_JP}}</td>
            <td>{{$user[ConstParams::EMAIL_VERIFIED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::LOGIN_ID_JP}}</td>
            <td>{{$user[ConstParams::LOGIN_ID]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_AT_JP}}</td>
            <td>{{$user[ConstParams::CREATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_AT_JP}}</td>
            <td>{{$user[ConstParams::UPDATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_BY_JP}}</td>
            <td>{{$user[ConstParams::CREATED_BY]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_BY_JP}}</td>
            <td>{{$user[ConstParams::UPDATED_BY]}}</td>
        </tr>
    </table>
    <h2>{{ConstParams::USER_SALARY_JP}}</h2>
    <table border="1">
        <tr>
            <td>{{ConstParams::HOURLY_WAGE_JP}}</td>
            <td>{{$salary[ConstParams::HOURLY_WAGE]}}{{ConstParams::CURRENCY_JP}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_AT_JP}}</td>
            <td>{{$salary[ConstParams::CREATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_AT_JP}}</td>
            <td>{{$salary[ConstParams::UPDATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_BY_JP}}</td>
            <td>{{$salary[ConstParams::CREATED_BY]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_BY_JP}}</td>
            <td>{{$salary[ConstParams::UPDATED_BY]}}</td>
        </tr>
    </table>
    <h2>{{ConstParams::USER_CONDITION_JP}}</h2>
    <table border="1">
        <tr>
            <td>{{ConstParams::HAS_ATTENDED_JP}}</td>
            <td>{{$condition['has_attended_jp']}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::IS_BREAKING_JP}}</td>
            <td>{{$condition['is_breaking_jp']}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_AT_JP}}</td>
            <td>{{$condition[ConstParams::CREATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_AT_JP}}</td>
            <td>{{$condition[ConstParams::UPDATED_AT]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::CREATED_BY_JP}}</td>
            <td>{{$condition[ConstParams::CREATED_BY]}}</td>
        </tr>
        <tr>
            <td>{{ConstParams::UPDATED_BY_JP}}</td>
            <td>{{$condition[ConstParams::UPDATED_BY]}}</td>
        </tr>
    </table>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection