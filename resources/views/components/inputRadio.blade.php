<div class="mb-4">
    <div class="mb-4">
        <span class="block md:text-xl text-lg text-black font-bold mb-2">{{$label}}</span>
    </div>
    <div class="flex md:flex-row flex-col">
        @foreach ($items as $item)
        <div class="inline-block mb-5">
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
                class="block text-black font-semibold text-center border border-black rounded-xl px-3 py-2 mr-2 bg-blue-200"
            >
                {{$item['name_jp']}}
            </label>    
        </div>
        @endforeach
    </div>
</div>

<style>
    input[type="radio"]:checked + label {
        color: white;
        background-color: rgb(37,99,235);
    }
    input[type="radio"]:hover + label {
        color: black;
        background-color: rgb(141, 185, 255);
        cursor: pointer;
    }
</style>
