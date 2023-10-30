@extends('layouts.base')
@section('title', 'トップ')
@section('content')
<div class="p-4 border-b-2 border-b-blue-500 font-bold md:text-3xl text-2xl">
    @if (Auth::check())
    <span>{{Auth::user()->getKanjiFullName()}}さん、こんにちは！</span>
    @else
    <span>ログインしていません</span>
    @endif
</div>
<div>
    <nav>
        <ul>
            <li class="p-4 border-b-2 border-b-blue-500">
                <a href="{{route('stamps.index')}}" class="flex items-center hover:text-blue-800">
                    <span class="i-lucide-stamp w-8 h-8 mt-1 flex-shrink-0"></span>
                    <span class="ml-4 font-bold md:text-3xl text-2xl">打刻</span>
                </a>
            </li>
            @if (Auth::check())
                @if (Auth::user()->is_admin)
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('users.create')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-user-plus-2 w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">{{ConstParams::USER_JP}}登録</span>
                        </a>
                    </li>
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('users.search')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-users-2 w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">{{ConstParams::USER_JP}}検索</span>
                        </a>
                    </li>
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('at_records.create')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-list-plus w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">{{ConstParams::AT_RECORD_JP}}登録</span>
                        </a>
                    </li>
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('at_records.search')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-file-search w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">{{ConstParams::AT_RECORD_JP}}検索</span>
                        </a>
                    </li>
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('summary.index')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-table w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">日別実績集計表</span>
                        </a>
                    </li>
                    <li class="p-4 border-b-2 border-b-blue-500">
                        <a href="{{route('logout')}}" class="flex items-center hover:text-blue-800">
                            <span class="i-lucide-log-out w-8 h-8 mt-1 flex-shrink-0"></span>
                            <span class="ml-4 font-bold md:text-3xl text-2xl">ログアウト</span>
                        </a>
                    </li>
                @endif
            @else
                <li class="p-4 border-b-2 border-b-blue-500">
                    <a href="{{route('login.form')}}" class="flex items-center hover:text-blue-800">
                        <span class="i-lucide-log-in w-8 h-8 mt-1 flex-shrink-0"></span>
                        <span class="ml-4 font-bold md:text-3xl text-2xl">ログイン</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>

@endsection

@section('footer')
@endsection