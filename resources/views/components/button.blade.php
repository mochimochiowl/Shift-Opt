<button 
    type="{{$type}}" 
    @if (isset($w_full) && $w_full)
        class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold rounded-md py-2 px-4 mb-4 mr-4 w-full"
    @else
        class="bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold rounded-md py-2 px-4 mb-4 mr-4"
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