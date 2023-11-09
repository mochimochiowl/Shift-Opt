@extends('layouts.base')
@section('title', '変更処理結果')
@section('content')
<div>
    @if ($count === 0)
       @component('components.message',['message' => ConstParams::PASSWORD_JP . 'を変更できませんでした。時間をおいてから再度お試しください。'])
       @endcomponent
    @else
    <div class="my-4 font-semibold md:text-3xl text-2xl">
        <span>以下のユーザーのパスワードを変更しました。</span>
    </div>
        @component('components.userBriefInfo',['user_data' => $user_data])
        @endcomponent
        <div class="inline-block mb-2 mr-1">
            @component('components.link', [
                'href'=> route('top'),
                'label'=> 'トップに戻る',
            ])
            @endcomponent
        </div>
    @endif
</div>
@endsection

@section('footer')
@endsection