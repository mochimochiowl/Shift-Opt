<header class="sticky z-20 top-0 flex justify-between items-center h-24 p-8 bg-blue-500">
    <h1>
        <a href="{{route('top')}}" class="flex items-center text-white">
            <span class="inline-block i-lucide-calendar-clock w-8 h-8 mr-2"></span>
            <span class="inline-block text-3xl font-bold">Shift-Opt</span>
        </a>
    </h1>
    <div class="inline-block text-xl font-semibold">
        @if (Auth::check())
            <span>{{Auth::user()->getKanjiFullName()}} としてログイン中</span>
        @else
        @endif
    </div>
    <nav>
        <button class="fixed z-30 top-8 right-8 text-white" onclick="toggleMenu()">
            <span id="openBtn" class="inline-block i-lucide-menu w-8 h-8"></span>
            <span id="closeBtn" class="inline-block i-lucide-x w-8 h-8 hidden"></span>
        </button>
        <ul id="menu" class="fixed top-0 left-0 w-full text-center text-white font-bold bg-blue-500 translate-x-full transition duration-300 ease-linear">
            @if (Auth::check())
                @if (Auth::user()->isAdmin())
                <li class="p-3"><a href="{{route('users.create')}}" class="">スタッフ登録画面</a></li>
                <li class="p-3"><a href="{{route('users.search')}}" class="">{{ConstParams::USER_JP}}検索画面</a></li>
                <li class="p-3"><a href="{{route('at_records.search')}}" class="">{{ConstParams::AT_RECORD_JP}}検索画面</a></li>
                <li class="p-3"><a href="{{route('summary.index')}}" class="">サマリー画面</a></li>
                @endif
            @endif
            <li class="p-3"><a href="{{route('stamps.index')}}" class="">打刻画面</a></li>
            <li class="p-3"><a href="{{route('debug')}}" class="">CSS確認</a></li>      
            @if (Auth::check())
            <li class="p-3"><a href="{{route('logout')}}" class="">ログアウトする</a></li>
            @else
            <li class="p-3"><a href="{{route('login.form')}}" class="">ログインする</a></li>
            @endif
        </ul>
    </nav>
</header>  