@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '登録画面')
@section('content')

<form action="{{route('at_records.store')}}" method="post">
    @csrf
    @component('components.inputText', [
        'type' => 'text',
        'name'=> 'target_login_id',
        'name_jp'=> ConstParams::LOGIN_ID_JP,
        'value' => old('target_login_id') ?? '',
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::AT_SESSION_ID,
        'name_jp'=> ConstParams::AT_SESSION_ID_JP,
        'value' => old(ConstParams::AT_SESSION_ID) ?? '',
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    @component('components.inputRadio', [
    'label' => ConstParams::AT_RECORD_TYPE_JP,
    'items' => [
            [
                'name'=> ConstParams::AT_RECORD_TYPE,
                'name_jp'=> ConstParams::AT_RECORD_START_WORK_JP,
                'value'=> ConstParams::AT_RECORD_START_WORK,
                'checked'=> (old(ConstParams::AT_RECORD_TYPE) == ConstParams::AT_RECORD_START_WORK),
            ],
            [
                'name'=> ConstParams::AT_RECORD_TYPE,
                'name_jp'=> ConstParams::AT_RECORD_FINISH_WORK_JP,
                'value'=> ConstParams::AT_RECORD_FINISH_WORK,
                'checked'=> (old(ConstParams::AT_RECORD_TYPE) == ConstParams::AT_RECORD_FINISH_WORK),
            ],
            [
                'name'=> ConstParams::AT_RECORD_TYPE,
                'name_jp'=> ConstParams::AT_RECORD_START_BREAK_JP,
                'value'=> ConstParams::AT_RECORD_START_BREAK,
                'checked'=> (old(ConstParams::AT_RECORD_TYPE) == ConstParams::AT_RECORD_START_BREAK),
            ],
            [
                'name'=> ConstParams::AT_RECORD_TYPE,
                'name_jp'=> ConstParams::AT_RECORD_FINISH_BREAK_JP,
                'value'=> ConstParams::AT_RECORD_FINISH_BREAK,
                'checked'=> (old(ConstParams::AT_RECORD_TYPE) == ConstParams::AT_RECORD_FINISH_BREAK),
            ],
        ],
    ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'date',
        'name'=> ConstParams::AT_RECORD_DATE,
        'name_jp'=> ConstParams::AT_RECORD_DATE_JP,
        'value' => old(ConstParams::AT_RECORD_DATE) ?? getToday(),
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'time',
        'name'=> ConstParams::AT_RECORD_TIME,
        'name_jp'=> ConstParams::AT_RECORD_TIME_JP,
        'value' => old(ConstParams::AT_RECORD_TIME) ?? getCurrentTime(),
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    <input type="hidden" name="created_by_user_id" value="{{Auth::user()->user_id}}">
    <input type="hidden" name="is_admin" value="true">
    <div class="pt-4">
        @component('components.button', [
            'type' => 'submit',
            'label' => '登録',
            'w_full' => true,
            ])
        @endcomponent
    </div>
</form>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection