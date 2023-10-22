<div class="mb-4">
    <button 
    type="{{$type}}" 
    class="bg-blue-500 hover:bg-blue-600 text-white text-2xl font-semibold rounded-md py-2 px-4 w-full"
    @if (isset($value) && $value !== '')
        {{' value=' . $value}}       
    @endif
    @if (isset($onclick) && $onclick !== '')
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
</div>