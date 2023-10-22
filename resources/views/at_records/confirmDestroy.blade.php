@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '削除確認画面')
@section('content')
<div>

</div>
@component('components.message',['message' => 'データを一度削除すると、戻すことはできません。'])
@endcomponent
@component('components.h2',['title' => ConstParams::AT_RECORD_JP])
@endcomponent

@component('components.infoTable', [
    'labels'=> $at_record_labels,
    'data'=> $at_record_data,
])
@endcomponent
<div>
    <div class="mb-4">
        @component('components.link', [
            'href'=> route('at_records.search'),
            'label'=> '検索に戻る',
        ])
        @endcomponent
    </div>
    @component('components.message',['message' => '本当に削除してもよろしいですか？'])
    @endcomponent
    <form action="{{route('at_records.delete', [ConstParams::AT_RECORD_ID => $at_record_id])}}" method="POST">
        @csrf
        @method('DELETE')
        @component('components.button', [
            'type' => 'submit',
            'label' => 'このユーザーを削除する',
            'w_full' => true,
            ])
        @endcomponent
    </form>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection