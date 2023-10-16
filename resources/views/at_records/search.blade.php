@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '検索画面')
@section('content')
@if ($messages)
<div class="alert alert-success">
    <ul>
        @foreach ($messages->all() as $message)
            <li>{{$message->type}} : {{$message->text}}</li>
        @endforeach
    </ul>
</div>
@endif
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
        <label for="start_date">開始日:</label>
        <input type="date" id="start_date" name="start_date" value="{{$search_requirements['start_date'] ?? $default_dates['start_date']}}">
        <label for="end_date">終了日:</label>
        <input type="date" id="end_date" name="end_date" value="{{$search_requirements['end_date'] ?? $default_dates['end_date']}}">
    </div>
    <div>
        <label>
            <input type="radio" name="search_field" value="all" @if(old('search_field', 'all') == 'all') checked @endif required> 全件表示
        </label>
        <label>
            <input type="radio" name="search_field" value="{{ConstParams::USER_ID}}" @if(old('search_field') == ConstParams::USER_ID) checked @endif required> {{ConstParams::USER_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="{{ConstParams::LOGIN_ID}}" @if(old('search_field') == ConstParams::LOGIN_ID) checked @endif required> {{ConstParams::LOGIN_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="name" @if(old('search_field') == 'name') checked @endif required> 名前（漢字・かな）
        </label>
    </div>
    <div>
        <input type="text" name="keyword" placeholder="キーワードを入力してください" value="{{old('keyword', $keyword ?? '')}}">
        <input type="submit" value="検索">
        <input type="submit" value="CSV出力" formaction="{{route('at_records.exportCsv')}}" formmethod="POST">
    </div>
</form>

<hr>
<a href="{{route('at_records.create')}}">データの新規作成</a>
<hr>

@if ($results)
<h2>検索ワード</h2>
<div>
    <p>検索種類   : {{$search_requirements['search_field']}}</p>
    <p>検索ワード : {{$search_requirements['keyword']}}</p>
    <p>開始日　　 : {{$search_requirements['start_date']}}</p>
    <p>終了日　　 : {{$search_requirements['end_date']}}</p>
    <p>ヒット件数 : {{count($results)}}</p>
</div>
<h2>検索結果</h2>
<table>
    <thead>
        <tr>
            <th>{{ConstParams::AT_RECORD_ID_JP}}</th>
            <th>{{ConstParams::AT_SESSION_ID_JP}}</th>
            <th>{{ConstParams::USER_ID_JP}}</th>
            <th>名前</th>
            <th>なまえ</th>
            <th>{{ConstParams::AT_RECORD_TYPE_JP}}</th>
            <th>{{ConstParams::AT_RECORD_DATE_JP}}</th>
            <th>{{ConstParams::AT_RECORD_TIME_JP}}</th>
            <th>詳細</th>
            <th>編集</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td>{{$result[ConstParams::AT_RECORD_ID]}}</td>
            <td>{{$result[ConstParams::AT_SESSION_ID]}}</td>
            <td>{{$result[ConstParams::USER_ID]}}</td>
            <td>{{$result[ConstParams::KANJI_LAST_NAME]}} {{$result[ConstParams::KANJI_FIRST_NAME]}}</td>
            <td>{{$result[ConstParams::KANA_LAST_NAME]}} {{$result[ConstParams::KANA_FIRST_NAME]}}</td>
            <td>{{$result[ConstParams::AT_RECORD_TYPE_TRANSLATED]}}</td>
            <td>{{$result[ConstParams::AT_RECORD_DATE]}}</td>
            <td>{{$result[ConstParams::AT_RECORD_TIME]}}</td>
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