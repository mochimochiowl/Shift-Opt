@extends('layouts.base')
@section('title', ConstParams::USER_JP . '作成成功')
@section('content')
<div>
    @if (!isset($user_id))
       @component('components.message',['message' => ConstParams::USER_JP . 'を作成できませんでした。時間をおいてから再度お試しください。'])
       @endcomponent
    @else
        @component('components.h2',['title' => ConstParams::USER_JP])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.edit', [ConstParams::USER_ID => $user_id]),
            'label'=> '編集する',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.show', [ConstParams::USER_ID => $user_id]),
            'label'=> '詳細画面へ',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('users.search'),
            'label'=> '検索画面へ',
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