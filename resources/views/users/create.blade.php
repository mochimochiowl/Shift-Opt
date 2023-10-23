@extends('layouts.base')
@section('title', 'スタッフ登録画面')
@section('content')
  <form action="{{route('users.store')}}" method="post">
  @csrf
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::KANJI_LAST_NAME,
      'name_jp'=> ConstParams::KANJI_LAST_NAME_JP,
      'value' => old(ConstParams::KANJI_LAST_NAME) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::KANJI_FIRST_NAME,
      'name_jp'=> ConstParams::KANJI_FIRST_NAME_JP,
      'value' => old(ConstParams::KANJI_FIRST_NAME) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::KANA_LAST_NAME,
      'name_jp'=> ConstParams::KANA_LAST_NAME_JP,
      'value' => old(ConstParams::KANA_LAST_NAME) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::KANA_FIRST_NAME,
      'name_jp'=> ConstParams::KANA_FIRST_NAME_JP,
      'value' => old(ConstParams::KANA_FIRST_NAME) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'email',
      'name'=> ConstParams::EMAIL,
      'name_jp'=> ConstParams::EMAIL_JP,
      'value' => old(ConstParams::EMAIL) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::LOGIN_ID,
      'name_jp'=> ConstParams::LOGIN_ID_JP,
      'value' => old(ConstParams::LOGIN_ID) ?? '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'password',
      'name'=> ConstParams::PASSWORD,
      'name_jp'=> ConstParams::PASSWORD_JP,
      'value' => '',
      'placeholder' => '',
      'autocomplete'=> 'off',
      'valied'=> true,
      ])
    @endcomponent
    @component('components.inputRadio', [
      'label' => ConstParams::IS_ADMIN_JP,
      'items' => [
              [
                  'name'=> ConstParams::IS_ADMIN,
                  'name_jp'=> ConstParams::ADMIN_JP,
                  'value'=> "true",
                  'checked'=> false,
              ],
              [
                  'name'=> ConstParams::IS_ADMIN,
                  'name_jp'=> ConstParams::NOT_ADMIN_JP,
                  'value'=> "false",
                  'checked'=> true,
              ],
          ],
      ])
    @endcomponent
    <div class="pt-4">
      @component('components.btnBlue', [
          'type' => 'submit',
          'label' => '登録',
          'w_full' => true,
          ])
      @endcomponent
    </div>
  </form>
@endsection

@section('footer')
@endsection