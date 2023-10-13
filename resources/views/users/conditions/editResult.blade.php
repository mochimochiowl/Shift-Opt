@extends('layouts.base')
@section('title', ConstParams::USER_SALARY_JP . '更新処理成功画面')
@section('content')
<div>
    @if ($count === 0)
    <p>データが更新できませんでした。</p>
    @else
    <p>データを更新しました。</p>
    <table border="1">
        <thead>
            <tr>
                <th>項目</th>
                <th>登録内容</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ConstParams::USER_ID_JP}}</td>
                <td>{{$user_data[ConstParams::USER_ID]}}</td>
            </tr>
            <tr>
                <td>名前</td>
                <td>{{$user_data[ConstParams::KANJI_LAST_NAME]}} {{$user_data[ConstParams::KANJI_FIRST_NAME]}}</td>
            </tr>
            <tr>
                <td>なまえ</td>
                <td>{{$user_data[ConstParams::KANA_LAST_NAME]}} {{$user_data[ConstParams::KANA_FIRST_NAME]}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::HAS_ATTENDED_JP}}</td>
                <td>{{$condition_data['has_attended_jp']}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::IS_BREAKING_JP}}</td>
                <td>{{$condition_data['is_breaking_jp']}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::CREATED_AT_JP}}</td>
                <td>{{$condition_data[ConstParams::CREATED_AT]}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::UPDATED_AT_JP}}</td>
                <td>{{$condition_data[ConstParams::UPDATED_AT]}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::CREATED_BY_JP}}</td>
                <td>{{$condition_data[ConstParams::CREATED_BY]}}</td>
            </tr>
            <tr>
                <td>{{ConstParams::UPDATED_BY_JP}}</td>
                <td>{{$condition_data[ConstParams::UPDATED_BY]}}</td>
            </tr>
        </tbody>
    </table>
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection