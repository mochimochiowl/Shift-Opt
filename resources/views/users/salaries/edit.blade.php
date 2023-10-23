@extends('layouts.base')
@section('title', '編集画面')
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
@if ($user_data && $salary_data)
@component('components.userBriefInfo',['user_data' => $user_data])
@endcomponent
<form action="{{route('users.salaries.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="{{ConstParams::USER_ID}}" value="{{$user_data[ConstParams::USER_ID]}}">
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::HOURLY_WAGE,
        'name_jp'=> ConstParams::HOURLY_WAGE_JP,
        'value' => $salary_data[ConstParams::HOURLY_WAGE],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    <div class="pt-4">
        @component('components.btnBlue', [
            'type' => 'submit',
            'label' => '更新',
            'w_full' => true,
            ])
        @endcomponent
      </div>
</form>
@else
    @component('components.message',['message' => ConstParams::USER_SALARY_JP . 'を取得できませんでした。時間をおいてから再度お試しください。'])
    @endcomponent
@endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection