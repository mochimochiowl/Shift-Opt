@extends('layouts.base')
@section('title', ConstParams::USER_JP . '更新処理成功画面')
@section('content')
<div>
    @if ($count === 0)
       @component('components.message',['message' => ConstParams::USER_JP . 'を更新できませんでした。時間をおいてから再度お試しください。'])
       @endcomponent
    @else
        @component('components.h2',['title' => ConstParams::USER_JP])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.edit', [ConstParams::USER_ID => $user_id]),
            'label'=> '再度編集する',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.show', [ConstParams::USER_ID => $user_id]),
            'label'=> '詳細に戻る',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.search'),
            'label'=> '検索に戻る',
        ])
        @endcomponent
        @component('components.infoTable', [
            'labels'=> $user_labels,
            'data'=> $user_data,
        ])
        @endcomponent
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection