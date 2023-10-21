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
<form action="{{route('users.search')}}" method="get">
    <h2>検索条件</h2>
    <div>
        <label>
            <input type="radio" name="search_field" value="all" checked> 全件表示
        </label>
        <label>
            <input type="radio" name="search_field" value="user_id"> {{ConstParams::USER_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="login_id"> {{ConstParams::LOGIN_ID_JP}}
        </label>
        <label>
            <input type="radio" name="search_field" value="name"> 名前（漢字・かな）
        </label>
        <label>
            <input type="radio" name="search_field" value="email"> {{ConstParams::EMAIL_JP}}
        </label>
    </div>
    <div>
        <input type="hidden" name="column" value="{{ConstParams::USER_ID}}">
        <input type="hidden" name="order" value="asc">
    </div>
    <div>
        <input type="text" name="keyword" placeholder="キーワードを入力してください" value="{{$keyword ?? ''}}">
        <input type="submit" value="検索">
    </div>
</form>

@if ($results)
@if ($search_requirements)
<h2>検索ワード</h2>
<div>
    <p>検索種類   : {{$search_requirements['search_field_jp'] ?? ''}}</p>
    <p>検索ワード : {{$search_requirements['keyword'] ?? ''}}</p>
    <p>ヒット件数 : {{count($results)}}</p>
</div>
@endif
<h2>検索結果</h2>
<table class="border-collapse w-9/12 my-5">
    <thead>
        <tr>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.search', [
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::USER_ID, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                ])}}">{{ConstParams::USER_ID_JP}}</a>
            </th>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.search', [
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANJI_LAST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                ])}}">{{ConstParams::KANJI_LAST_NAME_JP}}</a>
            </th>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.search', [
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANJI_FIRST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                ])}}">{{ConstParams::KANJI_FIRST_NAME_JP}}</a>
            </th>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.search', [
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANA_LAST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                ])}}">{{ConstParams::KANA_LAST_NAME_JP}}</a>
            </th>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.search', [
                'search_field' => $search_requirements['search_field'],
                'keyword' => $search_requirements['keyword'],
                'column' => ConstParams::KANA_FIRST_NAME, 
                'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                ])}}">{{ConstParams::KANA_FIRST_NAME_JP}}</a>
            </th>
            <th class="bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                詳細
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($results as $result)
        <tr>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$result->user_id}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$result->kanji_last_name}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$result->kanji_first_name}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$result->kana_last_name}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$result->kana_first_name}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                <a href="{{route('users.show', [ConstParams::USER_ID => $result->user_id])}}">詳細</a>
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

