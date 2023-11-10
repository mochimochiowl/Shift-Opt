@extends('layouts.base')
@section('title', ConstParams::USER_SALARY_JP . '編集')
@section('content')
@if ($user_data && $salary_data)
@component('components.messageForUser')
@endcomponent
@component('components.userBriefInfo',['user_data' => $user_data])
@endcomponent
<form action="{{route('users.salaries.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="{{ConstParams::USER_ID}}" value="{{$user_data[ConstParams::USER_ID]}}">
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::HOURLY_WAGE,
        'name_jp'=> ConstParams::HOURLY_WAGE_JP . ' (整数部分は6桁まで、小数は第2位まで入力可能 : 0 ~ 999999.99)',
        'value' => $salary_data[ConstParams::HOURLY_WAGE],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        // 'pattern'=> '^\d{1,6}(\.\d{1,2})?$',
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
<div class="my-5">
    @component('components.btnBlue', [
        'type' => 'button',
        'label' => '更新せずに戻る',
        'onclick' => 'movePreviousPage',
        'w_full' => true,
        ])
    @endcomponent
</div>
@endsection

@section('footer')
@endsection