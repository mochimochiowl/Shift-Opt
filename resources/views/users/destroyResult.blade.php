@extends('layouts.base')
@section('title', '削除処理結果')
@section('content')
@if ($count === 0)
    @component('components.message',['message' => ConstParams::USER_JP . 'を削除できませんでした。時間をおいてから再度お試しください。'])
    @endcomponent
@else
    @component('components.h2',['title' => '削除した' . ConstParams::USER_JP])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $user_labels,
        'data'=> $user_data,
    ])
    @endcomponent
@endif
@component('components.link', [
    'href'=> route('users.search'),
    'label'=> '検索に戻る',
])
@endcomponent
@endsection

@section('footer')
@endsection