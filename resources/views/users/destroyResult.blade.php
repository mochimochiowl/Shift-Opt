@extends('layouts.base')
@section('title', ConstParams::USER_JP . '削除処理成功')
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
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection