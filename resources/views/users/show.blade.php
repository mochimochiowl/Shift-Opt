@extends('layouts.base')
@section('title', ConstParams::USER_JP . '詳細画面')
@section('content')
    <div class="pt-4">
        @component('components.btnBlue', [
            'type' => 'button',
            'label' => '戻る',
            'onclick' => 'movePreviousPage',
            'w_full' => true,
            ])
        @endcomponent
    </div>
    @component('components.h2',['title' => ConstParams::USER_JP])
    @endcomponent
    @component('components.link', [
        'href'=> route('users.edit', [ConstParams::USER_ID => $user_id]),
        'label'=> '編集',
    ])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $user_labels,
        'data'=> $user_data,
    ])
    @endcomponent
    @component('components.h2',['title' => ConstParams::USER_SALARY_JP])
    @endcomponent
    @component('components.link', [
        'href'=> route('users.salaries.edit', [ConstParams::USER_ID => $user_id]),
        'label'=> '編集',
    ])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $salary_labels,
        'data'=> $salary_data,
    ])
    @endcomponent
    @component('components.h2',['title' => ConstParams::USER_CONDITION_JP])
    @endcomponent
    @component('components.link', [
        'href'=> route('users.conditions.edit', [ConstParams::USER_ID => $user_id]),
        'label'=> '編集',
    ])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $condition_labels,
        'data'=> $condition_data,
    ])
    @endcomponent
    @component('components.btnBlue', [
        'type' => 'button',
        'label' => '戻る',
        'onclick' => 'movePreviousPage',
        'w_full' => true,
        ])
    @endcomponent
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection