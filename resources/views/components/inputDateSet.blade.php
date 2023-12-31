<div>
    @component('components.inputText', [
        'type' => 'date',
        'name'=> $name,
        'name_jp'=> $name_jp,
        'value' => $value,
        'placeholder' => '',
        'autocomplete'=> 'off',
        'valied'=> true,
        ])
    @endcomponent
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
            'type' => 'button',
            'label' => '前日',
            'onclick' => 'setPreviousDay',
            'arg' => "'#" . $name . "'",
            ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
            'type' => 'button',
            'label' => '今日',
            'onclick' => 'setToday',
            'arg' => "'#" . $name . "'",
            ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
        'type' => 'button',
        'label' => '翌日',
        'onclick' => 'setNextDay',
        'arg' => "'#" . $name . "'",
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
        'type' => 'button',
        'label' => '先月初',
        'onclick' => 'setStartOfLastMonth',
        'arg' => "'#" . $name . "'",
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
        'type' => 'button',
        'label' => '先月末',
        'onclick' => 'setEndOfLastMonth',
        'arg' => "'#" . $name . "'",
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
        'type' => 'button',
        'label' => '今月初',
        'onclick' => 'setStartOfThisMonth',
        'arg' => "'#" . $name . "'",
        ])
        @endcomponent
    </div>
    <div class="inline-block mb-2 mr-1">
        @component('components.btnBlue', [
        'type' => 'button',
        'label' => '今月末',
        'onclick' => 'setEndOfThisMonth',
        'arg' => "'#" . $name . "'",
        ])
        @endcomponent
    </div>
</div>