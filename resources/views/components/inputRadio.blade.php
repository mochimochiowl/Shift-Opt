<div class="mb-4">
    <div class="mb-4">
        <span class="block text-black font-semibold">{{$label}}</span>
    </div>
    @foreach ($items as $item)
        <input 
            type="radio" 
            name="{{$item['name']}}" 
            id="{{$item['name']}}_{{$item['value']}}" 
            class="hidden" 
            value="{{$item['value']}}" 
            {{ $item['checked'] ? 'checked' : '' }}
        >
        <label 
            for="{{$item['name']}}_{{$item['value']}}" 
            class="text-black font-semibold border border-black rounded-xl px-3 py-2 mr-2 bg-blue-200"
        >
            {{$item['name_jp']}}
        </label>    
    @endforeach
</div>

<style>
    input[type="radio"]:checked + label {
        color: white;
        background-color: rgb(59,130,246);
    }
</style>
