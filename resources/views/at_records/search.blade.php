@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '検索画面')
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
<form action="{{route('at_records.search.result')}}" method="post">
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
    </div>
    <div>
        <input type="text" name="keyword" placeholder="キーワードを入力してください" value="{{$keyword ?? ''}}">
    </div>
    <div>
        <label for="start_date">開始日:</label>
        <input type="date" id="start_date" name="start_date" value="{{$default_dates['start_date']}}">
        <label for="end_date">終了日:</label>
        <input type="date" id="end_date" name="end_date" value="{{$default_dates['end_date']}}">
    </div>
    <div>
        <input type="submit" value="検索">
    </div>


</form>

@if ($results)
<h2>検索ワード</h2>
<div>
    <p>検索種類   : {{$search_requirements['search_field']}}</p>
    <p>検索ワード : {{$search_requirements['keyword']}}</p>
    <p>開始日　　 : {{$search_requirements['start_date']}}</p>
    <p>終了日　　 : {{$search_requirements['end_date']}}</p>
    <p>ヒット件数 : {{$results->count()}}</p>
</div>
<h2>検索結果</h2>
<table>
    <thead>
        <tr>
            <th>{{ConstParams::AT_RECORD_ID_JP}}</th>
            <th>{{ConstParams::USER_ID_JP}}</th>
            <th>名前</th>
            <th>なまえ</th>
            <th>{{ConstParams::AT_RECORD_TYPE_JP}}</th>
            <th>{{ConstParams::AT_RECORD_TIME_JP}}</th>
            <th>詳細</th>
            <th>編集</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td>{{$result['at_record_id']}}</td>
            <td>{{$result['user_id']}}</td>
            <td>{{$result['kanji_last_name']}} {{$result['kanji_first_name']}}</td>
            <td>{{$result['kana_last_name']}} {{$result['kana_first_name']}}</td>
            <td>{{$result['at_record_type_jp']}}</td>
            <td>{{$result['at_record_time']}}</td>
            <td>
                <a href="{{route('at_records.show', [ConstParams::AT_RECORD_ID => $result[ConstParams::AT_RECORD_ID]])}}">詳細</a>
            </td>
            <td>
                <a href="{{route('at_records.edit', [ConstParams::AT_RECORD_ID => $result[ConstParams::AT_RECORD_ID]])}}">編集</a>
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

