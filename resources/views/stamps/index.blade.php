@extends('layouts.base')
@section('title', '打刻')
@section('content')
<div class="px-2 py-2 text-4xl font-bold text-center text-black rounded-xl bg-blue-200">
    <span id="realTimer" class="">{{getCurrentTime()}}</span>
</div>
<form action="" method="post" class="px-2 py-2 mt-4 text-black rounded-xl bg-blue-200">
    @csrf
    @component('components.inputText', [
        'type' => 'text',
        'name'=> 'target_login_id',
        'name_jp'=> ConstParams::LOGIN_ID_JP,
        'value' => old('target_login_id') ?? '',
        'autocomplete'=> 'off',
        'valied'=> true,
        'maxlength'=> '20',
        ])
    @endcomponent
    <div class="pt-2">
        <div class="mb-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => ConstParams::AT_RECORD_START_WORK_JP,
                'formaction' => route('stamps.startWork'),
                'formmethod' => 'post',
                'w_full' => true,
                ])
            @endcomponent
        </div>
        <div class="mb-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => ConstParams::AT_RECORD_FINISH_WORK_JP,
                'formaction' => route('stamps.finishWork'),
                'formmethod' => 'post',
                'w_full' => true,
                ])
            @endcomponent
        </div>
        <div class="mb-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => ConstParams::AT_RECORD_START_BREAK_JP,
                'formaction' => route('stamps.startBreak'),
                'formmethod' => 'post',
                'w_full' => true,
                ])
            @endcomponent
        </div>
        <div class="mb-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => ConstParams::AT_RECORD_FINISH_BREAK_JP,
                'formaction' => route('stamps.finishBreak'),
                'formmethod' => 'post',
                'w_full' => true,
                ])
            @endcomponent
        </div>
    </div>
</form>
@endsection

@section('footer')
@endsection