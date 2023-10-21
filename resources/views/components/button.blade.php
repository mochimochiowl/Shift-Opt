<div class="mb-4">
    <button 
    type="{{$type}}" 
    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full"
    {{($value !== '') ? ' value="' . $value . '"' : ''}}
    >
        {{$label}}
    </button>
</div>