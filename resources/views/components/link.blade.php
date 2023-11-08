<a href={{$href}}
@if (isset($w_full) && $w_full)
    class="inline-block whitespace-nowrap bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4 w-full h-auto border-b-4 border-b-gray-500"
@else
    class="inline-block whitespace-nowrap bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4 h-auto border-b-4  border-b-gray-500"
@endif
>
    {{$label}}
</a>