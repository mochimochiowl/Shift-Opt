<div class="mb-4">
    <label for="{{$name}}" class="block text-black font-semibold">
        {{$name_jp}}
        <span class="ml-4 text-red-800" {{($valied) ? 'hidden' : ''}}>＊この項目は編集できません。</span>
    </label>
    <input 
    type="{{$type}}" 
    id="{{$name}}" 
    name="{{$name}}" 
    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" 
    value="{{$value}}"
    {{($placeholder !== '') ? ' placeholder=' . $placeholder : ''}}
    autocomplete="{{$autocomplete}}"
    {{(!$valied) ? ' disabled' : ''}}
     >
</div>