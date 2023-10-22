<div class="p-4 mb-3 text-2xl rounded-xl bg-blue-200">
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