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
                <a href="{{route('stamps.index')}}" class="flex justify-center p-3">
                    <span class="inline-block i-lucide-stamp w-5 h-5 mr-2"></span>
                    <span class="inline-block">打刻</span>
                </a>
            </li>
            @if (Auth::check())
                @if (Auth::user()->is_admin)
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('users.create')}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-user-plus-2 w-6 h-6 mr-2"></span>
                            <span class="inline-block">{{ConstParams::USER_JP}}登録</span>
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('users.search')}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-users-2 w-6 h-6 mr-2"></span>
                            <span class="inline-block">{{ConstParams::USER_JP}}検索</span>
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('at_records.create')}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-list-plus w-6 h-6 mr-2"></span>
                            <span class="inline-block">{{ConstParams::AT_RECORD_JP}}登録</span>
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('at_records.search')}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-file-search w-6 h-6 mr-2"></span>
                            <span class="inline-block">{{ConstParams::AT_RECORD_JP}}検索</span>
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('summary.index')}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-table w-6 h-6 mr-2"></span>
                            <span class="inline-block">日別実績集計表</span>
                        </a>
                    </li>
                    <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                        <a href="{{route('users.password.edit', [ConstParams::USER_ID => Auth::user()->user_id])}}" class="flex justify-center p-3">
                            <span class="inline-block i-lucide-key-round w-6 h-6 mr-2"></span>
                            <span class="inline-block">パスワード変更</span>
                        </a>
                    </li>
                @endif
            @endif
            @if (Auth::check())
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="{{route('logout')}}" class="flex justify-center p-3">
                    <span class="inline-block i-lucide-log-out w-6 h-6 mr-2"></span>
                    <span class="inline-block">ログアウト</span>
                </a>
            </li>
            @else
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="{{route('login.form')}}" class="flex justify-center p-3">
                    <span class="inline-block i-lucide-log-in w-6 h-6 mr-2"></span>
                    <span class="inline-block">ログイン</span>
                </a>
            </li>
            @endif
            <li class="p-0 hover:text-gray-100 hover:bg-blue-400">
                <a href="https://github.com/mochimochiowl/Shift-Opt" class="flex justify-center p-3">
                    <span class="inline-block i-grommet-icons-github w-6 h-6 mr-2"></span>
                    <span class="inline-block">コードをみる</span>
                </a>
            </li>
        </ul>
    </nav>
</header>  