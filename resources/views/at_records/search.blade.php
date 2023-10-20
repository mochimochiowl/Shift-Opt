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
<form action="{{route('at_records.search')}}" method="get">
    <h2>検索条件</h2>
    <div>
        <div>
            <label for="start_date">開始日:</label>
            <button type="button" onclick="setStartOfMonth()">今月初</button>
            <input type="date" id="start_date" name="start_date" value="{{$search_requirements['start_date'] ?? $default_dates['start_date']}}">
        </div>
        <div>
            <label for="end_date">終了日:</label>
            <button type="button" onclick="setEndOfMonth()">今月末</button>
            <input type="date" id="end_date" name="end_date" value="{{$search_requirements['end_date'] ?? $default_dates['end_date']}}">
        </div>
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
        <input type="hidden" name="column" value="datetime">
        <input type="hidden" name="order" value="asc">
    </div>
    <div>
        <input type="text" name="keyword" placeholder="キーワードを入力してください" value="{{old('keyword', $keyword ?? '')}}">
        <input type="submit" value="検索" formaction="{{route('at_records.search')}}">
        <input type="submit" value="CSV出力" formaction="{{route('at_records.export')}}">
    </div>
</form>

<hr>
<a href="{{route('at_records.create')}}">データの新規作成</a>
<hr>

@if ($results)
@if (($search_requirements['search_field_jp'])&&($search_requirements['keyword'])&&($search_requirements['start_date'])&&($search_requirements['end_date']))
<h2>検索ワード</h2>
<div>
    <p>検索種類   : {{$search_requirements['search_field_jp']}}</p>
    <p>検索ワード : {{$search_requirements['keyword']}}</p>
    <p>開始日　　 : {{$search_requirements['start_date']}}</p>
    <p>終了日　　 : {{$search_requirements['end_date']}}</p>
    <p>ヒット件数 : {{count($results)}}</p>
</div>
@endif
<h2>検索結果</h2>
<table>
    <thead>
        <tr>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::AT_RECORD_ID, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::AT_RECORD_ID_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::USER_ID, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::USER_ID_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANJI_LAST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::KANJI_LAST_NAME_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANJI_FIRST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::KANJI_FIRST_NAME_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANA_LAST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::KANA_LAST_NAME_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANA_FIRST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::KANA_FIRST_NAME_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::AT_RECORD_TYPE, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::AT_RECORD_TYPE_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::AT_RECORD_DATE, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::AT_RECORD_DATE_JP}}</a>
            </th>
            <th>
                <a href="{{route('at_records.search', [
                'start_date' => $search_requirements['start_date'],
                'end_date' => $search_requirements['end_date'],
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::AT_RECORD_TIME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                ])}}">{{ConstParams::AT_RECORD_TIME_JP}}</a>
            </th>
            <th>詳細</th>
            <th>編集</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td>{{$result[ConstParams::AT_RECORD_ID]}}</td>
            <td>{{$result[ConstParams::USER_ID]}}</td>
            <td>{{$result[ConstParams::KANJI_LAST_NAME]}}</td>
            <td>{{$result[ConstParams::KANJI_FIRST_NAME]}}</td>
            <td>{{$result[ConstParams::KANA_LAST_NAME]}}</td>
            <td>{{$result[ConstParams::KANA_FIRST_NAME]}}</td>
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
{{ $results->appends(request()->except('page'))->links() }}
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection