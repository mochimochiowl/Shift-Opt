@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '検索')
@section('content')
<form action="{{route('at_records.search')}}" method="get">
    <div class="p-4 mb-3 rounded-xl bg-blue-200">
        @component('components.h2',['title' => '検索条件'])
        @endcomponent
        @component('components.inputDateSet',[
            'name' => 'start_date',
            'name_jp' => '開始日',
            'value' => $search_requirements['start_date'] ?? $default_dates['start_date'],
            ])
        @endcomponent
        @component('components.inputDateSet',[
            'name' => 'end_date',
            'name_jp' => '終了日',
            'value' => $search_requirements['end_date'] ?? $default_dates['end_date'],
            ])
        @endcomponent
        @component('components.inputRadio', [
            'label' => '種別',
            'items' => [
                    [
                        'name'=> 'search_field',
                        'name_jp'=> '全件表示',
                        'value'=> 'all',
                        'checked'=> true,
                    ],
                    [
                        'name'=> 'search_field',
                        'name_jp'=> ConstParams::USER_ID_JP,
                        'value'=> ConstParams::USER_ID,
                        'checked'=> false,
                    ],
                    [
                        'name'=> 'search_field',
                        'name_jp'=> ConstParams::LOGIN_ID_JP,
                        'value'=> ConstParams::LOGIN_ID,
                        'checked'=> false,
                    ],
                    [
                        'name'=> 'search_field',
                        'name_jp'=> '名前（漢字・かな）',
                        'value'=> 'name',
                        'checked'=> false,
                    ],
                ],
            ])
          @endcomponent
          @component('components.inputText', [
            'type' => 'text',
            'name'=> 'keyword',
            'name_jp'=> 'キーワード',
            'value' => old('keyword') ?? '',
            'placeholder' => 'キーワードを入力してください',
            'autocomplete'=> 'off',
            'valied'=> true,
            ])
          @endcomponent
          <input type="hidden" name="column" value="datetime">
          <input type="hidden" name="order" value="asc">
        <div class="pt-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => '検索',
                'w_full' => true,
                'formaction' => route('at_records.search'),
                ])
            @endcomponent
        </div>
        <div class="pt-4 mb-3">
            @component('components.btnGreen', [
                'type' => 'submit',
                'label' => 'CSV出力',
                'w_full' => true,
                'formaction' => route('at_records.export'),
                ])
            @endcomponent
        </div>
        @component('components.hr')
        @endcomponent
        <div class="pt-3">
            @component('components.link', [
                'href'=> route('at_records.create'),
                'label'=> 'データの新規作成',
                'w_full' => true,
            ])
            @endcomponent
        </div>
    </div>
</form>

@if ($results)
    @if ($search_requirement_labels && $search_requirements)
        @component('components.searchRequirementsShow',[
            'search_requirement_labels' => $search_requirement_labels,
            'search_requirements_data' => $search_requirements_data,
            'count' => count($results),
            ])
        @endcomponent
    @endif
@component('components.h2',['title' => '検索結果'])
@endcomponent
<div class="overflow-x-auto">
    <table class="border-collapse w-full my-5">
        <thead>
            <tr>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::AT_RECORD_ID, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::AT_RECORD_ID_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::USER_ID, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::USER_ID_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANJI_LAST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::KANJI_LAST_NAME_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANJI_FIRST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::KANJI_FIRST_NAME_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANA_LAST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::KANA_LAST_NAME_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANA_FIRST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::KANA_FIRST_NAME_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::AT_RECORD_TYPE, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::AT_RECORD_TYPE_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::AT_RECORD_DATE, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::AT_RECORD_DATE_JP}}</a>
                </th>
                <th class=" whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('at_records.search', [
                    'start_date' => $search_requirements['start_date'],
                    'end_date' => $search_requirements['end_date'],
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::AT_RECORD_TIME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc',
                    ])}}">{{ConstParams::AT_RECORD_TIME_JP}}</a>
                </th>
                <th class="text-center whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    詳細
                </th>
                <th class="text-center whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    編集
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::AT_RECORD_ID]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::USER_ID]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::KANJI_LAST_NAME]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::KANJI_FIRST_NAME]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::KANA_LAST_NAME]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::KANA_FIRST_NAME]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{App\Models\AttendanceRecord::getTypeName($result[ConstParams::AT_RECORD_TYPE])}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::AT_RECORD_DATE]}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result[ConstParams::AT_RECORD_TIME]}}
                </td>
                <td class="text-center bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    @component('components.link', [
                        'href'=> route('at_records.show', [ConstParams::AT_RECORD_ID => $result[ConstParams::AT_RECORD_ID]]),
                        'label'=> '詳細',
                    ])
                    @endcomponent
                </td>
                <td class="text-center bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    @component('components.link', [
                        'href'=> route('at_records.edit', [ConstParams::AT_RECORD_ID => $result[ConstParams::AT_RECORD_ID]]),
                        'label'=> '編集',
                    ])
                    @endcomponent
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $results->appends(request()->except('page'))->links() }}
@else
    @component('components.message',['message' => 'データがありません。'])
    @endcomponent
@endif
@endsection

@section('footer')
@endsection