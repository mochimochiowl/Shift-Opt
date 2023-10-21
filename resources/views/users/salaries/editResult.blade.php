@extends('layouts.base')
@section('title', ConstParams::USER_SALARY_JP . '更新処理成功画面')
@section('content')
<div>
    @if ($count === 0)
    <p>データが更新できませんでした。</p>
    @else
    @component('components.h2',['title' => ConstParams::USER_SALARY_JP])
    @endcomponent
    @component('components.link', [
        'href'=> route('users.salaries.edit', [ConstParams::USER_ID => $user_id]),
        'label'=> '再度編集する',
    ])
    @endcomponent
    @component('components.link', [
        'href'=> route('users.search'),
        'label'=> '検索に戻る',
    ])
    @endcomponent
    @component('components.infoTable', [
        'labels'=> $salary_labels,
        'data'=> $salary_data,
    ])
    @endcomponent
    @endif
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection