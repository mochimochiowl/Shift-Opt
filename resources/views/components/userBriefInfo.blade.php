<div class="p-4 mb-3 md:text-xl text-lg rounded-xl bg-blue-200">
    @component('components.h2',['title' => '対象のユーザー'])
    @endcomponent
    <div>
        <span>{{ConstParams::USER_ID_JP}} :</span><span>{{$user_data[ConstParams::USER_ID]}}</span>
    </div>
    <div>
        <span>名前 :</span><span>{{$user_data[ConstParams::KANJI_LAST_NAME] . ' ' . $user_data[ConstParams::KANJI_FIRST_NAME]}}</span>
    </div>
    <div>
        <span>なまえ :</span><span>{{$user_data[ConstParams::KANA_LAST_NAME] . ' ' . $user_data[ConstParams::KANA_FIRST_NAME]}}</span>
    </div>
</div>