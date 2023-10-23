@extends('layouts.base')
@section('title', ConstParams::USER_JP . '詳細')
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
                'href'=> route('users.edit', [ConstParams::USER_ID => $user_id]),
                'label'=> '編集',
                ])
            @endcomponent
        </div>
    </div>
    @component('components.infoTable', [
        'labels'=> $user_labels,
        'data'=> $user_data,
    ])
    @endcomponent
    @component('components.h2',['title' => ConstParams::USER_SALARY_JP])
    @endcomponent
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
                'href'=> route('users.salaries.edit', [ConstParams::USER_ID => $user_id]),
                'label'=> '編集',
                ])
            @endcomponent
        </div>
    </div>
    @component('components.infoTable', [
        'labels'=> $salary_labels,
        'data'=> $salary_data,
    ])
    @endcomponent
    @component('components.h2',['title' => ConstParams::USER_CONDITION_JP])
    @endcomponent
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
                'href'=> route('users.conditions.edit', [ConstParams::USER_ID => $user_id]),
                'label'=> '編集',
                ])
            @endcomponent
        </div>
    </div>
    @component('components.infoTable', [
        'labels'=> $condition_labels,
        'data'=> $condition_data,
    ])
    @endcomponent
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection