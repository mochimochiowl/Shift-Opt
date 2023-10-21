@extends('layouts.base')
@section('title', ConstParams::USER_JP . '情報詳細画面')
@section('content')
    <h2 class="text-3xl font-semibold mb-4">{{ConstParams::USER_JP}}</h2>
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
    <h2 class="text-3xl font-semibold mb-4">{{ConstParams::USER_SALARY_JP}}</h2>
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
    <h2 class="text-3xl font-semibold mb-4">{{ConstParams::USER_CONDITION_JP}}</h2>
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
    @component('components.button', [
        'type' => 'button',
        'label' => '戻る',
        'value' => '',
        'onclick' => 'movePreviousPage',
        ])
    @endcomponent
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection