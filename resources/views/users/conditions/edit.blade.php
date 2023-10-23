@extends('layouts.base')
@section('title', ConstParams::USER_CONDITION_JP . '編集画面')
@section('content')
@if ($user_data && $condition_data)
@component('components.userBriefInfo',['user_data' => $user_data])
@endcomponent
<form action="{{route('users.conditions.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="{{ConstParams::USER_ID}}" value="{{$user_data[ConstParams::USER_ID]}}">
    @component('components.inputRadio', [
      'label' => ConstParams::HAS_ATTENDED_JP,
      'items' => [
              [
                  'name'=> ConstParams::HAS_ATTENDED,
                  'name_jp'=> ConstParams::HAS_ATTENDED_TRUE_JP,
                  'value'=> "1",
                  'checked'=> $condition_data[ConstParams::HAS_ATTENDED] ? true : false,
              ],
              [
                  'name'=> ConstParams::HAS_ATTENDED,
                  'name_jp'=> ConstParams::HAS_ATTENDED_FALSE_JP,
                  'value'=> "0",
                  'checked'=> !$condition_data[ConstParams::HAS_ATTENDED] ? true : false,
              ],
          ],
      ])
    @endcomponent
    @component('components.inputRadio', [
        'label' => ConstParams::IS_BREAKING_JP,
        'items' => [
                [
                    'name'=> ConstParams::IS_BREAKING,
                    'name_jp'=> ConstParams::IS_BREAKING_TRUE_JP,
                    'value'=> "1",
                    'checked'=> $condition_data[ConstParams::IS_BREAKING] ? true : false,
                ],
                [
                    'name'=> ConstParams::IS_BREAKING,
                    'name_jp'=> ConstParams::IS_BREAKING_FALSE_JP,
                    'value'=> "0",
                    'checked'=> !$condition_data[ConstParams::IS_BREAKING] ? true : false,
                ],
            ],
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