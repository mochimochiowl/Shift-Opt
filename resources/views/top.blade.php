@extends('layouts.base')
@section('title', 'トップ')
@section('content')
<div class="p-4 font-bold md:text-3xl text-2xl">
    @if (Auth::check())
        <div>
            <span>{{Auth::user()->getKanjiFullName()}}さん、こんにちは！</span>
        </div>
        <nav class="mt-8">
            <h2 class="my-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">メニュー</h2>
            <ul class="md:mx-8">
                <li class="p-4">
                    @component('components.iconLink', [
                        'href'=> route('stamps.index'),
                        'color' => 'blue',
                        'icon_class'=> 'i-lucide-stamp w-7 h-7 mt-1 mr-3 flex-shrink-0',
                        'label'=> '打刻',
                        'w_full' => true,
                    ])
                    @endcomponent
                </li>
                @if (Auth::check())
                    @if (Auth::user()->is_admin)
                        <li class="p-4">
                            @component('components.iconLink', [
                                'href'=> route('users.create'),
                                'color' => 'green',
                                'icon_class'=> 'i-lucide-user-plus-2 w-7 h-7 mt-1 mr-2 flex-shrink-0',
                                'label'=> ConstParams::USER_JP . '登録',
                                'w_full' => true,
                            ])
                            @endcomponent
                        </li>
                        <li class="p-4">
                            @component('components.iconLink', [
                                'href'=> route('users.search'),
                                'color' => 'green',
                                'icon_class'=> 'i-lucide-users-2 w-7 h-7 mt-1 mr-2 flex-shrink-0',
                                'label'=> ConstParams::USER_JP . '検索',
                                'w_full' => true,
                            ])
                            @endcomponent
                        </li>
                        <li class="p-4">
                            @component('components.iconLink', [
                                'href'=> route('at_records.create'),
                                'color' => 'green',
                                'icon_class'=> 'i-lucide-list-plus w-7 h-7 mt-1 mr-3 flex-shrink-0',
                                'label'=> ConstParams::AT_RECORD_JP . '登録',
                                'w_full' => true,
                            ])
                            @endcomponent
                        </li>
                        <li class="p-4">
                            @component('components.iconLink', [
                                'href'=> route('users.search'),
                                'color' => 'green',
                                'icon_class'=> 'i-lucide-file-search w-6 h-6 mt-1 mr-3 flex-shrink-0',
                                'label'=> ConstParams::AT_RECORD_JP . '検索',
                                'w_full' => true,
                            ])
                            @endcomponent
                        </li>
                        <li class="p-4">
                            @component('components.iconLink', [
                                'href'=> route('summary.index'),
                                'color' => 'green',
                                'icon_class'=> 'i-lucide-table w-6 h-6 mt-1 mr-3 flex-shrink-0',
                                'label'=> '日別実績集計表',
                                'w_full' => true,
                            ])
                            @endcomponent
                        </li>
                    @endif
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> route('users.password.edit', [ConstParams::USER_ID => Auth::user()->user_id]),
                            'color' => 'blue',
                            'icon_class'=> 'i-lucide-key-round w-6 h-6 mt-1 mr-3 flex-shrink-0',
                            'label'=> 'パスワード変更',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> route('logout'),
                            'color' => 'blue',
                            'icon_class'=> 'i-lucide-log-out w-6 h-6 mt-1 mr-3 flex-shrink-0',
                            'label'=> 'ログアウト',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                @else
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> route('login.form'),
                            'color' => 'blue',
                            'icon_class'=> 'i-lucide-log-in w-6 h-6 mt-1 mr-3 flex-shrink-0',
                            'label'=> 'ログイン',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                @endif
            </ul>
        </nav>
    @else
        <nav class="mt-8">
            <h2 class="my-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">メニュー</h2>
            <ul class="md:mx-8">
                <li class="p-4">
                    @component('components.iconLink', [
                        'href'=> route('stamps.index'),
                        'color' => 'blue',
                        'icon_class'=> 'i-lucide-stamp w-7 h-7 mt-1 mr-3 flex-shrink-0',
                        'label'=> '打刻',
                        'w_full' => true,
                    ])
                    @endcomponent
                </li>
                <li class="p-4">
                    @component('components.iconLink', [
                        'href'=> route('login.form'),
                        'color' => 'blue',
                        'icon_class'=> 'i-lucide-log-in w-6 h-6 mt-1 mr-3 flex-shrink-0',
                        'label'=> 'ログイン',
                        'w_full' => true,
                    ])
                    @endcomponent
                </li>
            </ul>
        </nav>
    @endif
</div>
@if (!Auth::check())
<div class="hidden opacity-100"></div>
<div id="explain_section">
    <div class="font-semibold md:text-2xl text-xl text-center">
        <div class="p-4 mx-4 md:mt-8 mt-4 text-center rounded-xl bg-blue-200">
            <div class="p-4 text-center">
                <span>▼初めての方へ▼</span>
            </div>
        </div>
    </div>
    <div id="top_image" class="flex items-center justify-center md:mt-12 mt-8 md:p-0 p-4">
        <img src="{{asset('/imgs/top.png')}}" width="800" alt="Shift-Opt イメージ画像">
    </div>
    <div id="guide" class="md:text-2xl text-xl">
        <div id="summary" class="md:mt-20 mt-12 opacity-0 transition-opacity duration-700">
            <h2 class="m-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">概要</h2>
            <div class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200">
                <div class="p-4 text-center">
                    <p>勤怠管理システムです。</p>
                    <p>時給制スタッフを雇用する会社の利用をイメージして製作しました。</p>
                </div>
            </div>
        </div>
        <div id="function" class="md:mt-16 mt-8">
            <h2 class="m-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">機能</h2>
            <div class="md:mt-12 mt-6">
                <div id="function-1" class="pb-12 border-b-2 border-y-gray-100 opacity-0 transition-opacity duration-700">
                    <div class="flex flex-col md:flex-row items-center justify-evenly p-4">
                        <div class="flex flex-col text-center w-full md:w-1/2 pt-2 pb-4 mx-4 my-8 rounded-xl bg-blue-200">
                            <h3 class="font-semibold text-2xl md:text-3xl mt-4 ">打刻</h3>
                            <p class="mt-8 md:mt-16 mb-4 mx-3">自分のPC、スマホから打刻できます。</p>
                        </div>
                        <div class="w-full md:w-4/12">
                            <img src="{{asset('imgs/screenshot_stamp.jpg')}}" alt="打刻画面のスクリーンショット" class="md:drop-shadow-2xl drop-shadow-xl">
                        </div>
                    </div>
                </div>
                <div id="function-2" class="md:mt-12 mt-3 pb-12 border-b-2 border-y-gray-100 opacity-0 transition-opacity duration-700">
                    <div class="flex md:flex-row flex-col-reverse items-center justify-evenly p-4">
                        <div class="w-full md:w-1/2">
                            <img src="{{asset('imgs/screenshot_menu.jpg')}}" alt="メニューのスクリーンショット" class="md:drop-shadow-2xl drop-shadow-xl">
                        </div>
                        <div class="flex flex-col text-center w-full md:w-1/2 pt-2 pb-4 mx-4 my-8 rounded-xl bg-blue-200">
                            <h3 class="font-semibold text-2xl md:text-3xl mt-4">データ操作、集計</h3>
                            <p class="mt-8 md:mt-16 mb-4 mx-3">管理者は、データの閲覧、編集、集計が可能です。(要ログイン)</p>
                        </div>
                    </div>
                </div>
                <div id="function-3" class="md:mt-12 mt-3 pb-12 border-b-2 border-y-gray-100 opacity-0 transition-opacity duration-700">
                    <div class="flex flex-col md:flex-row items-center justify-evenly p-4">
                        <div class="flex flex-col text-center w-full md:w-1/2 pt-2 pb-4 mx-4 my-8 rounded-xl bg-blue-200">
                            <h3 class="font-semibold text-2xl md:text-3xl mt-4">検索機能</h3>
                            <p class="mt-8 md:mt-16 mb-4 mx-3">スタッフ、打刻記録を検索可能です。打刻記録はCSVで出力し、外部で集計することも可能です。</p>
                        </div>
                        <div class="w-full md:w-6/12">
                            <img src="{{asset('imgs/screenshot_search.jpg')}}" alt="検索画面のスクリーンショット" class="md:drop-shadow-2xl drop-shadow-xl">
                        </div>
                    </div>
                </div>
                <div id="function-4" class="md:mt-12 mt-3 pb-12 opacity-0 transition-opacity duration-700">
                    <div class="flex md:flex-row flex-col-reverse items-center justify-evenly p-4">
                        <div class="w-full md:w-6/12">
                            <img src="{{asset('imgs/screenshot_summary.jpg')}}" alt="集計画面のスクリーンショット" class="md:drop-shadow-2xl drop-shadow-xl">
                        </div>
                        <div class="flex flex-col text-center w-full md:w-1/2 pt-2 pb-4 mx-4 my-8 rounded-xl bg-blue-200">
                            <h3 class="font-semibold text-2xl md:text-3xl mt-4">集計機能</h3>
                            <p class="mt-8 md:mt-16 mb-4 mx-3">打刻記録をもとに、労働時間、休憩時間、人件費の実績値を表示します。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="purpose" class="md:mt-20 mt-12 opacity-0 transition-opacity duration-700">
            <h2 class="m-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">製作した目的</h2>
            <div class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200">
                <div class="p-4 text-center">
                    <ul>
                        <li class="p-4">1. WEBアプリの製作に必要な基本的な技術や知識を、手を動かして習得するため。</li>
                        <li class="p-4">2. 2023年10月時点でのスキルレベルの参考資料として、コードを公開するため。</li>
                        <li class="p-4">
                            <a href="https://github.com/mochimochiowl/Shift-Opt" class="flex justify-center underline">
                                <span class="inline-block i-grommet-icons-github w-8 h-8 mr-2"></span>
                                <span class="inline-block">レポジトリはこちら</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="technology_used" class="md:mt-20 mt-12">
            <h2 class="m-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">使用した技術</h2>
            <div>
                <div id="tech-1" class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200 opacity-0 transition-opacity duration-700">
                    <h3 class="my-4 mx-8 p-4 font-semibold md:text-3xl text-2xl text-center border-b-2 border-b-gray-600">フロントエンド</h3>
                    <ul>
                        <li class="p-4">Vite</li>
                        <li class="p-4">Tailwind CSS</li>
                    </ul>
                </div>
                <div id="tech-2" class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200 opacity-0 transition-opacity duration-700">
                    <h3 class="my-4 mx-8 p-4 font-semibold md:text-3xl text-2xl text-center border-b-2 border-b-gray-600">バックエンド</h3>
                    <ul>
                        <li class="p-4">PHP</li>
                        <li class="p-4">Laravel</li>
                    </ul>
                </div>
                <div id="tech-3" class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200 opacity-0 transition-opacity duration-700">
                    <h3 class="my-4 mx-8 p-4 font-semibold md:text-3xl text-2xl text-center border-b-2 border-b-gray-600">データベース</h3>
                    <ul>
                        <li class="p-4">PostgreSQL</li>
                    </ul>
                </div>
                <div id="tech-4" class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200 opacity-0 transition-opacity duration-700">
                    <h3 class="my-4 mx-8 p-4 font-semibold md:text-3xl text-2xl text-center border-b-2 border-b-gray-600">サーバー、インフラ</h3>
                    <ul>
                        <li class="p-4">Nginx</li>
                        <li class="p-4">Google Compute Engine</li>
                        <li class="p-4">Docker</li>
                        <li class="p-4">Laravel Sail</li>
                    </ul>
                </div>
                <div id="tech-5" class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200 opacity-0 transition-opacity duration-700">
                    <h3 class="my-4 mx-8 p-4 font-semibold md:text-3xl text-2xl text-center border-b-2 border-b-gray-600">バージョン管理</h3>
                    <ul>
                        <li class="p-4">GitHub</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="duration" class="md:mt-20 mt-12 opacity-0 transition-opacity duration-700">
            <h2 class="m-4 p-4 font-semibold md:text-4xl text-3xl text-center border-y-2 border-y-gray-600">開発期間</h2>
            <div class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200">
                <div class="p-4 text-center">
                    <p>学習 : 約5週間</p>
                    <p class="md:text-xl text-sm md:mb-2 mb-1">(PHP、Laravel、WEBの知識等)</p>
                    <p>設計～実装 : 約5週間</p>
                </div>
            </div>
        </div>
        <div id="menu-below" class="md:mt-20 mt-12 opacity-0 transition-opacity duration-700">
            <div class="pt-2 pb-4 mx-4 mt-8 text-center rounded-xl bg-blue-200">
                <div class="p-4 text-center">
                    <p>ご覧いただきありがとうございます！</p>
                </div>
                <ul class="md:mx-8">
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> route('stamps.index'),
                            'color' => 'blue',
                            'icon_class'=> 'i-lucide-stamp w-7 h-7 mt-1 mr-3 flex-shrink-0',
                            'label'=> '打刻する',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> route('login.form'),
                            'color' => 'blue',
                            'icon_class'=> 'i-lucide-log-in w-6 h-6 mt-1 mr-3 flex-shrink-0',
                            'label'=> 'ログインする',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                    <li class="p-4">
                        @component('components.iconLink', [
                            'href'=> 'https://github.com/mochimochiowl/Shift-Opt',
                            'color' => 'blue',
                            'icon_class'=> 'i-grommet-icons-github w-8 h-8 mt-1 mr-2 flex-shrink-0',
                            'label'=> 'コードをみる',
                            'w_full' => true,
                        ])
                        @endcomponent
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif


@endsection

@section('footer')
@endsection