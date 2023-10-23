@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '更新処理成功')
@section('content')
<div>
    @if ($count === 0)
    @component('components.message',['message' => ConstParams::AT_RECORD_JP . 'を更新できませんでした。時間をおいてから再度お試しください。'])
    @endcomponent
    @else
    @component('components.h2',['title' => ConstParams::AT_RECORD_JP])
    @endcomponent
    <div class="inline-block mb-2 mr-1">
        @component('components.link', [
            'href'=> route('at_records.edit', [ConstParams::AT_RECORD_ID => $at_record_id]),
            'label'=> '再度編集する',
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.link', [
            'href'=> route('at_records.show', [ConstParams::AT_RECORD_ID => $at_record_id]),
            'label'=> '詳細に戻る',
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.link', [
            'href'=> route('at_records.search'),
            'label'=> '検索に戻る',
        ])
        @endcomponent
    </div>
    @component('components.infoTable', [
        'labels'=> $at_record_labels,
        'data'=> $at_record_data,
    ])
    @endcomponent
    @endif
</div>
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection