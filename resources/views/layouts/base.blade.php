<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <script src="{{asset('/dist/main.js')}}"></script>
    @vite('resources/css/app.css')
    </head>
    <body class="bg-blue-300"">
        @component('components.header')
        @endcomponent
        <div class="menu container mx-auto p-3">
            @section('error_display')
                @if ($errors->any())
                <div>
                    <ul class="px-2 py-2 rounded-xl font-bold text-left text-black bg-red-400">
                        @foreach ($errors->all() as $error)
                            @component('components.message',['message' => $error])
                            @endcomponent
                        @endforeach
                    </ul>
                </div>
                @endif
            @show
            <div class="lg:p-8 md:p-16 sm:p-10 p-8 w-full">
                <h1 class="inline-block text-4xl font-bold mb-4">@yield('title')</h1>
                @yield('content')
            </div>
        </div>
        <footer class="px-3 py-5 bg-blue-500 text-sm text-gray-200 text-center">
            @yield('footer')
        </footer>
    </body>
</html>