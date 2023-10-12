@extends('layouts.base')
@section('title', ConstParams::USER_JP . '検索画面')
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
<form action="{{route('users.search.result')}}" method="post">
    @csrf
    <h2>検索条件選択・入力</h2>
    <div>
        <label>
            <input type="radio" name="search_field" value="all" checked> 全件表示
        </label>
        <label>
            <input type="radio" name="search_field" value="user_id" required> {{ConstParams::USER_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="login_id" required> {{ConstParams::LOGIN_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="name"> 名前（漢字・かな）
        </label>
        <label>
            <input type="radio" name="search_field" value="email"> {{ConstParams::EMAIL_JP}}
        </label>
    </div>

    <div>
        <input type="text" name="keyword" placeholder="キーワードを入力してください" value="{{$keyword ?? ''}}">
        <input type="submit" value="検索">
    </div>
</form>

@if ($results)
<h2>検索ワード</h2>
<div>
    <p>検索種類   : {{$search_field}}</p>
    <p>検索ワード : {{$keyword}}</p>
    <p>ヒット件数 : {{$results->count()}}</p>
</div>
<h2>検索結果</h2>
<table>
    <thead>
        <tr>
            <th>{{ConstParams::USER_ID_JP}}</th>
            <th>{{ConstParams::KANJI_LAST_NAME_JP}}</th>
            <th>{{ConstParams::KANJI_FIRST_NAME_JP}}</th>
            <th>詳細</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td>{{$result->user_id}}</td>
            <td>{{$result->kanji_last_name}}</td>
            <td>{{$result->kanji_first_name}}</td>
            <td>
                <a href="{{route('users.show', [ConstParams::USER_ID => $result->user_id])}}">詳細</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection

