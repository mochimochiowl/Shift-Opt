<header class="sticky z-20 top-0 flex justify-between items-center h-24 p-8 bg-blue-500">
    <h1>
        <a href="{{route('top')}}" class="flex items-center text-white">
            <span class="inline-block i-lucide-calendar-clock w-8 h-8 mr-2"></span>
            <span class="inline-block text-3xl font-bold">Shift-Opt</span>
        </a>
    </h1>
    <nav>
        <button class="fixed z-30 top-8 right-8 text-white" onclick="toggleMenu()">
            <span id="openBtn" class="inline-block i-lucide-menu w-8 h-8"></span>
            <span id="closeBtn" class="inline-block i-lucide-x w-8 h-8 hidden"></span>
        </button>
        <ul id="menu" class="fixed top-0 left-0 w-full text-center text-white font-bold bg-blue-500 translate-x-full transition duration-300 ease-linear">
            @if (Auth::check())
                <li class="h-24 p-9 bg-blue-600">{{Auth::user()->getKanjiFullName()}}さん、こんにちは！</li>
                @else
                <li class="h-24 p-9 bg-blue-600">ログインしていません。</li>
            @endif
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="{{route('stamps.index')}}" class="block p-3">
                    打刻
                </a>
            </li>
            @if (Auth::check())
                @if (Auth::user()->is_admin)
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('users.create')}}" class="block p-3">
                            {{ConstParams::USER_JP}}登録
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('users.search')}}" class="block p-3">
                            {{ConstParams::USER_JP}}検索
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('at_records.create')}}" class="block p-3">
                            {{ConstParams::AT_RECORD_JP}}登録
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('at_records.search')}}" class="block p-3">
                            {{ConstParams::AT_RECORD_JP}}検索
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('summary.index')}}" class="block p-3">
                            日別実績集計表
                        </a>
                    </li>
                @endif
            @endif
            @if (Auth::check())
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="{{route('logout')}}" class="block p-3">
                    ログアウト
                </a>
            </li>
            @else
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="{{route('login.form')}}" class="block p-3">
                    ログイン
                </a>
            </li>
            @endif
        </ul>
    </nav>
</header>  