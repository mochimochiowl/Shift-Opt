@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '詳細')
@section('content')
<div class="flex justify-between items-center">
    <div class="inline mr-4">
        @component('components.btnBlue', [
            'type' => 'button',
            'label' => '戻る',
            'onclick' => 'movePreviousPage',
            ])
        @endcomponent
    </div>
    <div class="inline">
        @component('components.link', [
            'href'=> route('at_records.edit', [ConstParams::AT_RECORD_ID => $at_record_id]),
            'label'=> '編集',
            ])
        @endcomponent
    </div>
</div>
@component('components.infoTable', [
    'labels'=> $at_record_labels,
    'data'=> $at_record_data,
])
@endcomponent
@endsection
@section('footer')
    copyright 2023 CoderOwlWing
@endsection