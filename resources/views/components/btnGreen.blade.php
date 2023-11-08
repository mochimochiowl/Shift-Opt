<button 
    type="{{$type}}" 
    @if (isset($w_full) && $w_full)
        class="whitespace-nowrap bg-green-500 hover:bg-green-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4 w-full h-auto border-b-4 border-b-gray-500"
    @else
        class="whitespace-nowrap bg-green-500 hover:bg-green-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4 h-auto border-b-4 border-b-gray-500"
    @endif
    @if (isset($value) && $value !== '')
        {{' value=' . $value}}       
    @endif
    @if (isset($onclick) && $onclick !== '')
        @if (isset($arg) && $arg !== '')
            {{' onclick=' . $onclick . '(' . $arg . ')'}}       
        @endif
        {{' onclick=' . $onclick . '()'}}       
    @endif
    @if (isset($formaction) && $formaction !== '')
        {{' formaction=' . $formaction}}       
    @endif
    @if (isset($formmethod) && $formmethod !== '')
        {{' formmethod=' . $formmethod}}       
    @endif
    >
        {{$label}}
</button>