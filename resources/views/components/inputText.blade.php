<div class="mb-4">
    <label for="{{$name}}" class="block text-2xl text-black font-bold mb-2">
        {{$name_jp}}
        <span class="ml-4 text-red-800" {{($valied) ? 'hidden' : ''}}>＊この項目は編集できません。</span>
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
     >
</div>