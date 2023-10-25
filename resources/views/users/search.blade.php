@extends('layouts.base')
@section('title', ConstParams::USER_JP . '検索')
@section('content')
<form action="{{route('users.search')}}" method="get">
    <div class="p-4 mb-3 rounded-xl bg-blue-200">
        @component('components.h2',['title' => '検索条件'])
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
                    [
                        'name'=> 'search_field',
                        'name_jp'=> ConstParams::EMAIL_JP,
                        'value'=> ConstParams::EMAIL,
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
            'maxlength'=> '200',
            ])
          @endcomponent
        <input type="hidden" name="column" value="{{ConstParams::USER_ID}}">
        <input type="hidden" name="order" value="asc">
        <div class="pt-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => '検索',
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
<div class="overflow-x-auto p-4 mb-3 rounded-xl bg-blue-200">
    @component('components.h2',['title' => '検索結果'])
    @endcomponent
    <table class="border-collapse w-full my-5">
        <thead>
            <tr>
                <th class="whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('users.search', [
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::USER_ID, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                    ])}}">{{ConstParams::USER_ID_JP}}</a>
                </th>
                <th class="whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('users.search', [
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANJI_LAST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                    ])}}">{{ConstParams::KANJI_LAST_NAME_JP}}</a>
                </th>
                <th class="whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('users.search', [
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANJI_FIRST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                    ])}}">{{ConstParams::KANJI_FIRST_NAME_JP}}</a>
                </th>
                <th class="whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('users.search', [
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANA_LAST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                    ])}}">{{ConstParams::KANA_LAST_NAME_JP}}</a>
                </th>
                <th class="whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    <a href="{{route('users.search', [
                    'search_field' => $search_requirements['search_field'],
                    'keyword' => $search_requirements['keyword'],
                    'column' => ConstParams::KANA_FIRST_NAME, 
                    'order' => request('order', 'asc') == 'asc' ? 'desc' : 'asc'
                    ])}}">{{ConstParams::KANA_FIRST_NAME_JP}}</a>
                </th>
                <th class="text-center whitespace-nowrap w-2/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    詳細
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result->user_id}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result->kanji_last_name}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result->kanji_first_name}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result->kana_last_name}}
                </td>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$result->kana_first_name}}
                </td>
                <td class="text-center bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    @component('components.link', [
                        'href'=> route('users.show', [ConstParams::USER_ID => $result->user_id]),
                        'label'=> '詳細',
                    ])
                    @endcomponent
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $results->appends(request()->except('page'))->links() }}
@endif
@endsection

@section('footer')
@endsection

