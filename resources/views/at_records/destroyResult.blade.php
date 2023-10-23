@extends('layouts.base')
@section('title', '削除処理結果')
@section('content')
@if ($count === 0)
    @component('components.message',['message' => ConstParams::AT_RECORD_JP . 'を削除できませんでした。時間をおいてから再度お試しください。'])
    @endcomponent
@else
    @component('components.h2',['title' => '削除した' . ConstParams::AT_RECORD_JP])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $at_record_labels,
        'data'=> $at_record_data,
    ])
    @endcomponent
@endif
@component('components.link', [
    'href'=> route('at_records.search'),
    'label'=> '検索に戻る',
])
@endcomponent
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection