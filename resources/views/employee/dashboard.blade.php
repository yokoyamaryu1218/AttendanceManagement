<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div id="parent">
            <div id="child1">
                @include('menu.top.work')
            </div>
            <div id="child2">
                @include('menu.top.daily')
            </div>
        </div>
    </body>
</x-app-layout>
