<a href={{$href}}
@if (isset($w_full) && $w_full)
    class="flex items-center justify-center whitespace-nowrap bg-{{$color}}-500 hover:bg-{{$color}}-600 text-white text-lg font-semibold text-center rounded-md py-2 pl-4 pr-6 w-full h-auto drop-shadow-lg"
@else
    class="flex items-center justify-center whitespace-nowrap bg-{{$color}}-500 hover:bg-{{$color}}-600 text-white text-lg font-semibold text-center rounded-md py-2 pl-4 pr-6 h-auto drop-shadow-lg"
@endif
>
    @if (isset($icon_class) && $icon_class)
    <span class="{{$icon_class}}"></span>
    @endif
    <span
        @if (isset($icon_class) && $icon_class)
            class="font-bold md:text-2xl text-xl"
        @endif
    >{{$label}}</span>
</a>