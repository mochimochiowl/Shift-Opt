@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '削除')
@section('content')
<div>

</div>
@component('components.message',['message' => 'データを一度削除すると、戻すことはできません。'])
@endcomponent
@component('components.h2',['title' => '対象の' . ConstParams::AT_RECORD_JP])
@endcomponent

@component('components.infoTable', [
    'labels'=> $at_record_labels,
    'data'=> $at_record_data,
])
@endcomponent
<div>

    @component('components.message',['message' => '本当に削除してもよろしいですか？'])
    @endcomponent
    <form action="{{route('at_records.delete', [ConstParams::AT_RECORD_ID => $at_record_id])}}" method="POST">
        @csrf
        @method('DELETE')
        @component('components.btnRed', [
            'type' => 'submit',
            'label' => '削除する',
            'w_full' => true,
            ])
        @endcomponent
        <div class="my-4">
            @component('components.link', [
                'href'=> route('at_records.search'),
                'label'=> '検索に戻る',
                'w_full' => true,
            ])
            @endcomponent
        </div>
    </form>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection