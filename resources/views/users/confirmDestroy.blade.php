@extends('layouts.base')
@section('title', ConstParams::USER_JP . '削除確認画面')
@section('content')
@if ($user_data[ConstParams::USER_ID] === 1)
    <p>管理者ユーザーは削除できません。</p>
    @else
    <div>
        <p>以下 の データを削除します。</p>
        <p>データを一度削除すると、戻すことはできません。</p>
        @component('components.userInfo', ['user_data'=> $user_data])
        @endcomponent
    </div>
    <div>
        <p>本当に削除してもよろしいですか？</p>
        <form action="{{route('users.delete', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">このユーザーを削除する</button>
        </form>
    </div>
    @endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection