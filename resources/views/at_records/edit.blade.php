@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '編集画面')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@component('components.userBriefInfo',['user_data' => [
    ConstParams::USER_ID =>  $data[ConstParams::USER_ID],
    ConstParams::KANJI_LAST_NAME =>  $data[ConstParams::KANJI_LAST_NAME],
    ConstParams::KANJI_FIRST_NAME =>  $data[ConstParams::KANJI_FIRST_NAME],
    ConstParams::KANA_LAST_NAME =>  $data[ConstParams::KANA_LAST_NAME],
    ConstParams::KANA_FIRST_NAME =>  $data[ConstParams::KANA_FIRST_NAME],
]])
@endcomponent
@if ($data)
<form action="{{route('at_records.update', [ConstParams::AT_RECORD_ID => $data[ConstParams::AT_RECORD_ID]])}}" method="POST" class="mb-3">
    @csrf
    @method('PUT')
    @component('components.inputText', [
        'type' => 'text',
        'name'=> ConstParams::AT_RECORD_ID,
        'name_jp'=> ConstParams::AT_RECORD_ID_JP,
        'value' => $data[ConstParams::AT_RECORD_ID],
        'autocomplete'=> 'off',
        'valied'=> false,
        ])
    @endcomponent
    @component('components.inputText', [
      'type' => 'text',
      'name'=> ConstParams::AT_SESSION_ID,
      'name_jp'=> ConstParams::AT_SESSION_ID_JP,
      'value' => $data[ConstParams::AT_SESSION_ID],
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
                  'checked'=> ($data[ConstParams::AT_RECORD_TYPE] == ConstParams::AT_RECORD_START_WORK),
              ],
              [
                  'name'=> ConstParams::AT_RECORD_TYPE,
                  'name_jp'=> ConstParams::AT_RECORD_FINISH_WORK_JP,
                  'value'=> ConstParams::AT_RECORD_FINISH_WORK,
                  'checked'=> ($data[ConstParams::AT_RECORD_TYPE] == ConstParams::AT_RECORD_FINISH_WORK)
              ],
              [
                  'name'=> ConstParams::AT_RECORD_TYPE,
                  'name_jp'=> ConstParams::AT_RECORD_START_BREAK_JP,
                  'value'=> ConstParams::AT_RECORD_START_BREAK,
                  'checked'=> ($data[ConstParams::AT_RECORD_TYPE] == ConstParams::AT_RECORD_START_BREAK)
              ],
              [
                  'name'=> ConstParams::AT_RECORD_TYPE,
                  'name_jp'=> ConstParams::AT_RECORD_FINISH_BREAK_JP,
                  'value'=> ConstParams::AT_RECORD_FINISH_BREAK,
                  'checked'=> ($data[ConstParams::AT_RECORD_TYPE] == ConstParams::AT_RECORD_FINISH_BREAK)
              ],
          ],
      ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'date',
        'name'=> ConstParams::AT_RECORD_DATE,
        'name_jp'=> ConstParams::AT_RECORD_DATE_JP,
        'value' => $data[ConstParams::AT_RECORD_DATE],
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    @component('components.inputText', [
        'type' => 'time',
        'name'=> ConstParams::AT_RECORD_TIME,
        'name_jp'=> ConstParams::AT_RECORD_TIME_JP,
        'value' => $data[ConstParams::AT_RECORD_TIME],
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
    <div class="pt-4">
        @component('components.button', [
            'type' => 'submit',
            'label' => '更新',
            'w_full' => true,
            ])
        @endcomponent
    </div>
</form>
@else
    @component('components.message',['message' => ConstParams::AT_RECORD_JP . 'を更新できませんでした。時間をおいてから再度お試しください。'])
    @endcomponent
@endif
@component('components.hr')
@endcomponent
<div>
    @if ($data)
    <form action="{{route('at_records.delete.confirm', [ConstParams::AT_RECORD_ID => $data[ConstParams::AT_RECORD_ID]])}}" method="POST">
        @csrf
        <input type="hidden" name="logged_in_user_name" value="{{Auth::user()->getKanjiFullName();}}">
        <div class="pt-4">
            @component('components.button', [
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
    copyright 2023 CoderOwlWing
@endsection