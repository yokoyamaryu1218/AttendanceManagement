<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="pt-20 pl-24">
                <label>
                    <select>
                        <option selected> 月度 </option>
                        <option>6月度</option>
                        <option>7月度</option>
                    </select>
                </label>
                {{ Auth::guard('employee')->user()->name }}さん
            </div>
            <div class="container px-5 py-5 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    @include('menu.daily')
                </div>
            </div>
        </section>
    </body>
</x-app-layout>