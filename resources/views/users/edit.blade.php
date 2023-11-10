@extends('layouts.base')
@section('title', ConstParams::USER_JP . '編集')
@section('content')
@if ($user_data)
@component('components.messageForUser')
@endcomponent
<form action="{{route('users.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
    @csrf
    @method('PUT')
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::USER_ID,
        'name_jp'=> ConstParams::USER_ID_JP,
        'value' => $user_data[ConstParams::USER_ID],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> false,
        ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::KANJI_LAST_NAME,
      'name_jp'=> ConstParams::KANJI_LAST_NAME_JP,
      'value' => $user_data[ConstParams::KANJI_LAST_NAME],
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      'maxlength'=> '15',
      ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::KANJI_FIRST_NAME,
        'name_jp'=> ConstParams::KANJI_FIRST_NAME_JP,
        'value' => $user_data[ConstParams::KANJI_FIRST_NAME],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '15',
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::KANA_LAST_NAME,
        'name_jp'=> ConstParams::KANA_LAST_NAME_JP,
        'value' => $user_data[ConstParams::KANA_LAST_NAME],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '15',
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::KANA_FIRST_NAME,
        'name_jp'=> ConstParams::KANA_FIRST_NAME_JP,
        'value' => $user_data[ConstParams::KANA_FIRST_NAME],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '15',
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'email',
        'name'=> ConstParams::EMAIL,
        'name_jp'=> ConstParams::EMAIL_JP,
        'value' => $user_data[ConstParams::EMAIL],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '200',
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::EMAIL_VERIFIED_AT,
        'name_jp'=> ConstParams::EMAIL_VERIFIED_AT_JP,
        'value' => $user_data[ConstParams::EMAIL_VERIFIED_AT],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> false,
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::LOGIN_ID,
        'name_jp'=> ConstParams::LOGIN_ID_JP,
        'value' => $user_data[ConstParams::LOGIN_ID],
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '20',
        ])
    @endcomponent
    @component('components.inputRadio', [
      'label' => ConstParams::IS_ADMIN_JP,
      'items' => [
              [
                  'name'=> ConstParams::IS_ADMIN,
                  'name_jp'=> ConstParams::ADMIN_JP,
                  'value'=> "true",
                  'checked'=> $user_data[ConstParams::IS_ADMIN],
              ],
              [
                  'name'=> ConstParams::IS_ADMIN,
                  'name_jp'=> ConstParams::NOT_ADMIN_JP,
                  'value'=> "false",
                  'checked'=> !$user_data[ConstParams::IS_ADMIN],
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
    @component('components.message',['message' => ConstParams::USER_JP . 'を取得できませんでした。時間をおいてから再度お試しください。'])
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
@component('components.hr')
@endcomponent
<div>
    @if ($user_data)
    <form action="{{route('users.delete.confirm', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
        @csrf
        <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
        <div class="pt-4">
            @component('components.btnRed', [
                'type' => 'submit',
                'label' => '削除',
                'w_full' => true,
                ])
            @endcomponent
          </div>
    </form>
    @endif
</div>
@endsection

@section('footer')
@endsection