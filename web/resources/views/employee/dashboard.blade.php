<style>
    @media (min-width: 600px) {
        #parent {
            display: flex;
        }

        #child1 {
            flex-grow: 1;
        }

        #child2 {
            flex-grow: 1;
        }
    }
</style>

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div id="parent">
            <div id="child1">
                @include('top.work')
            </div>
            <div id="child2">@include('top.daily')</div>
        </div>
    </body>
</x-app-layout>
