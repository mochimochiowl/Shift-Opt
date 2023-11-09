@extends('layouts.base')
@section('title', ConstParams::PASSWORD_JP . '変更')
@section('content')
@if ($user_data)
    @component('components.userBriefInfo',['user_data' => $user_data])
    @endcomponent
    <form action="{{route('users.password.update', [ConstParams::USER_ID => $user_data[ConstParams::USER_ID]])}}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="{{ConstParams::USER_ID}}" value="{{$user_data[ConstParams::USER_ID]}}" hidden>
        <input type="text" name="{{ConstParams::UPDATED_BY}}" value="{{$user_data[ConstParams::KANJI_LAST_NAME] . ' ' . $user_data[ConstParams::KANJI_FIRST_NAME]}}" hidden>
        @component('components.inputText', [
            'type' => ConstParams::PASSWORD,
            'name'=> 'old_pwd',
            'name_jp'=> '現在の' . ConstParams::PASSWORD_JP . 'を入力してください。',
            'value' => '',
            'placeholder' => '',
            'autocomplete'=> 'off',
            'valied'=> true,
            'maxlength'=> '20',
            ])
        @endcomponent
        @component('components.inputText', [
            'type' => ConstParams::PASSWORD,
            'name'=> 'new_pwd_1',
            'name_jp'=> '新しい' . ConstParams::PASSWORD_JP . 'を入力してください。',
            'value' => '',
            'placeholder' => '',
            'autocomplete'=> 'off',
            'valied'=> true,
            'maxlength'=> '20',
            ])
        @endcomponent
        @component('components.inputText', [
            'type' => ConstParams::PASSWORD,
            'name'=> 'new_pwd_2',
            'name_jp'=> '確認のため、もう一度新しい' . ConstParams::PASSWORD_JP . 'を入力してください。',
            'value' => '',
            'placeholder' => '',
            'autocomplete'=> 'off',
            'valied'=> true,
            'maxlength'=> '20',
            ])
        @endcomponent
        <div class="pt-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => '変更',
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
@endsection

@section('footer')
@endsection