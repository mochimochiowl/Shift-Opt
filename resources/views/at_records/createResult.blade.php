@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '作成成功')
@section('content')
<div>
    @if (!isset($at_record_id))
       @component('components.message',['message' => ConstParams::AT_RECORD_JP . 'を作成できませんでした。時間をおいてから再度お試しください。'])
       @endcomponent
    @else
        @component('components.h2',['title' => ConstParams::AT_RECORD_JP])
        @endcomponent
        @component('components.link', [
            'href'=> route('at_records.edit', [ConstParams::AT_RECORD_ID => $at_record_id]),
            'label'=> '編集する',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('at_records.show', [ConstParams::AT_RECORD_ID => $at_record_id]),
            'label'=> '詳細画面へ',
        ])
        @endcomponent
        @component('components.link', [
            'href'=> route('at_records.search'),
            'label'=> '検索画面へ',
        ])
        @endcomponent
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