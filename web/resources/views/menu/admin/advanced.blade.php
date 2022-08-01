<!-- https://tailwindcomponents.com/component/input-field -->
<!-- 詳細設定画面のblade -->
<script src="{{ asset('js/admin/search.js') }}" defer></script>

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">詳細設定画面</h1>
            </div>
            <form>
                <div class="grid gap-6 mb-6 lg:grid-cols-1">
                    総勤務時間が8時間を超える場合は、1時間
                </div>
                <div class="grid gap-6 mb-6 lg:grid-cols-1">
                    6時間を超え、8時間未満の場合は、45分
                </div>
                <div class="grid gap-6 mb-12 lg:grid-cols-1">
                    6時間未満の場合は、休憩なし
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 flex mx-auto focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">更新</button>
                    <input class="btn btn-warning my-0" type="button" value="戻る" onclick="location.href='./';">
                </div>
            </form>
        </div>
    </body>
</x-app-layout>