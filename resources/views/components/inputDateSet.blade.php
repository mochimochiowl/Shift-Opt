<div>
    @component('components.inputText', [
        'type' => 'date',
        'name'=> $name,
        'name_jp'=> $name_jp,
        'value' => $value,
        'placeholder' => 'キーワードを入力してください',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '昨日',
        'onclick' => 'setPreviousDay',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '今日',
        'onclick' => 'setToday',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '明日',
        'onclick' => 'setNextDay',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '先月初',
        'onclick' => 'setStartOfLastMonth',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '先月末',
        'onclick' => 'setEndOfLastMonth',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '今月初',
        'onclick' => 'setStartOfThisMonth',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
    @component('components.button', [
        'type' => 'button',
        'label' => '今月末',
        'onclick' => 'setEndOfThisMonth',
        'arg' => "'#" . $name . "'",
        ])
    @endcomponent
</div>