@extends('layouts.base')
@section('title', ConstParams::USER_JP . '更新処理成功画面')
@section('content')
<div>
    @if ($count === 0)
    <p>データが更新できませんでした。</p>
    @else
    <p>データを更新しました。</p>
    @component('components.userInfo', ['user_data'=> $user_data])
    @endcomponent
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection