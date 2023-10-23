@extends('layouts.base')
@section('title', ConstParams::USER_JP . '削除確認画面')
@section('content')
@if ($is_admin)
    @component('components.message',['message' => ConstParams::ADMIN_JP . 'は削除できません。'])
    @endcomponent
    <p></p>
@else
    @component('components.message',['message' => 'データを一度削除すると、戻すことはできません。'])
    @endcomponent
    @component('components.h2',['title' => ConstParams::USER_JP])
    @endcomponent

    @component('components.infoTable', [
        'labels'=> $user_labels,
        'data'=> $user_data,
    ])
    @endcomponent
<div>
    <div class="mb-4">
        @component('components.link', [
            'href'=> route('users.search'),
            'label'=> '検索に戻る',
        ])
        @endcomponent
    </div>
    @component('components.message',['message' => '本当に削除してもよろしいですか？'])
    @endcomponent
    <form action="{{route('users.delete', [ConstParams::USER_ID => $user_id])}}" method="POST">
        @csrf
        @method('DELETE')
        @component('components.btnRed', [
            'type' => 'submit',
            'label' => 'このユーザーを削除する',
            'w_full' => true,
            ])
        @endcomponent
    </form>
</div>
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection