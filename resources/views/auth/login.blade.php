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
                'autocomplete'=> 'off',
                ])
            @endcomponent
            @component('components.inputText', [
                'type' => 'password',
                'name'=> ConstParams::PASSWORD,
                'name_jp'=> ConstParams::PASSWORD_JP,
                'autocomplete'=> 'off',
                ])
            @endcomponent
            <div class="pt-4">
                @component('components.button', [
                'type' => 'submit',
                'label' => '登録',
                'value' => '',
                'onclick' => '',
                ])
                @endcomponent
            </div>
        </form>
    @endif
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection