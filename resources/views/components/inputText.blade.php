<div class="mb-4">
    <label for="{{$name}}" class="block md:text-xl text-lg text-black font-bold mb-2">
        {{$name_jp}}
        <span class="md:ml-3 m-0 md:text-lg text-base text-red-800" {{($valied) ? ' hidden' : ''}}>＊編集不可</span>
    </label>
    <input 
    type="{{$type}}" 
    id="{{$name}}" 
    name="{{$name}}" 
    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" 
    value="{{$value}}"
    @if (isset($placeholder) && $placeholder !== '')
        {{' placeholder=' . $placeholder}}       
    @endif
    autocomplete="{{$autocomplete}}"
    @if (isset($valied) && !$valied)
         disabled     
    @endif
    @if (isset($minlength) && $minlength !== '')
        {{' minlength=' . $minlength}}       
    @endif
    @if (isset($maxlength) && $maxlength !== '')
        {{' maxlength=' . $maxlength}}       
    @endif
    >
</div>