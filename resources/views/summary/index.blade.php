@extends('layouts.base')
@section('title', '日別実績集計表')
@section('content')
<div class="p-4 mb-3 rounded-xl bg-blue-200">
    <form action="{{route('summary.post')}}" method="POST">
        @csrf
        @component('components.inputDateSet',[
            'name' => 'date',
            'name_jp' => '対象日',
            'value' => $data['date'] ?? getToday(),
            ])
        @endcomponent
        <div class="pt-4">
            @component('components.btnBlue', [
                'type' => 'submit',
                'label' => '表示',
                'w_full' => true,
                ])
            @endcomponent
        </div>
    </form>
</div>
@if ($data)
@component('components.h2',['title' => $data['date']])
@endcomponent
<div class="overflow-x-auto">
    <table class="border-collapse w-full my-5">
        <thead>
            <tr>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    名前
                </th>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    入｜出
                </th>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    労働時間
                </th>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    休憩時間
                </th>
                <th class="whitespace-nowrap bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                    人件費
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data['rows'] as $row)
            <tr>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$row['name']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$row['start_work_time']}} | {{$row['finish_work_time']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$row['working_hours']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$row['breaking_hours']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$row['cost_of_labor']}}
                </td>
            </tr>
        @endforeach
            <tr>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    合計
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    ー
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$data['sums']['working_hours']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$data['sums']['breaking_hours']}}
                </td>
                <td class="whitespace-nowrap bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$data['sums']['cost_of_labor']}}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@else
    @component('components.message',['message' => 'データがありません。'])
    @endcomponent
@endif

@endsection

@section('footer')
@endsection