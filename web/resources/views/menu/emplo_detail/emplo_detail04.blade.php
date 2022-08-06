<!-- https://tailwindcomponents.com/component/input-field -->
<!-- admin側　退職確認画面のblade -->
<script src="{{ asset('js/admin/search.js') }}" defer></script>

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        @foreach($employee_lists as $emplo)
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">退職確認画面</h1>
                以下の従業員の退職処理を行います。よろしいでしょうか。
            </div>
            <form method="POST" action="{{ route('admin.destroy')}}">
            <!-- 復職・退職確認画面に出す従業員詳細画面のbladeへ -->
            @include('menu.emplo_detail.emplo_detail07')
            </form>
        </div>
        @endforeach
        <!-- トグル用のJava -->
        <script>
            function clickBtn7() {
                document.getElementById("subord_authority").value = "1";
            }
        </script>
        <!-- トグル用のJavaここまで -->
    </body>
</x-app-layout>