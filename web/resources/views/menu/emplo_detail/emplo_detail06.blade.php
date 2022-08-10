<!-- admin側 退職者一覧のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <div class="flex flex-col text-center w-full mb-20">
                        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">退職者一覧</h1>
                    </div>
                    <!-- 従業員の一覧表示部分 -->
                    <!-- 退職者リストがある場合、退職者一覧を表示する -->
                    @if(!(empty($employee_lists[0])))
                    <!-- 従業員の一覧を表示する共通用bladeへ -->
                    @include('menu.emplo_detail.emplo_detail02')
                    @else
                    <div class="text-center">
                        <!-- 退職者がいない場合は何も出さない -->
                        <h5>現在、退職者はいないようです。</h5></BR>
                    </div>
                    <div class="text-right">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.dashboard') }}">
                            {{ __('従業員一覧へ') }}
                        </a>
                    </div>
                    @endif
            </div>
            </div>
        </section>
    </body>
</x-app-layout>