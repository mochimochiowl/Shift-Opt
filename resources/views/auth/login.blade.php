@extends('layouts.base')
@section('title', 'ログイン画面')
@section('content')
    @if (Auth::check())
        @component('components.message',['message' => '既にログイン済みです。'])
        @endcomponent
    @else
        <form action="login" method="post">
            @csrf
            @component('components.inputText', [
                'type' => 'text',
                'name'=> ConstParams::LOGIN_ID,
                'name_jp'=> ConstParams::LOGIN_ID_JP,
                'value' => old(ConstParams::LOGIN_ID) ?? '',
                'placeholder' => '',
                'autocomplete'=> 'off',
                'valied'=> true,
                'maxlength'=> '20',
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
                'maxlength'=> '20',
                ])
            @endcomponent
            {{-- @component('components.inputRadio', [
                'label' => '自動ログイン',
                'items' => [
                        [
                            'name'=> 'remember_me',
                            'name_jp'=> 'する',
                            'value'=> "true",
                            'checked'=> false,
                        ],
                        [
                            'name'=> 'remember_me',
                            'name_jp'=> 'しない',
                            'value'=> "false",
                            'checked'=> true,
                        ],
                    ],
                ])
                @endcomponent --}}
            <div class="pt-4">
                @component('components.btnBlue', [
                'type' => 'submit',
                'label' => 'ログイン',
                'w_full' => true,
                ])
                @endcomponent
            </div>
        </form>
    @endif
@endsection

@section('footer')
@endsection