@extends('layouts.base')
@section('title', 'ユーザー情報削除処理成功画面')
@section('content')
<div>
    <p>データ を削除しました。</p>
    <p>削除した項目数：{{$count}}</p>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection