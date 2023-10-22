<a href={{$href}}
@if (isset($w_full) && $w_full)
    class="inline-block whitespace-nowrap bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4 w-full"
@else
    class="whitespace-nowrap bg-blue-500 hover:bg-blue-600 text-white text-lg font-semibold text-center rounded-md py-2 px-4"
@endif
>
    {{$label}}
</a>