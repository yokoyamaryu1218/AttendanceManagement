<!-- エラー画面のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">エラーページ</h1>
            </div>
            <div class="grid gap-6 mb-6 lg:grid-cols-1">
                申し訳ございません。エラーが発生しました。
            </div>

            <div class="flex justify-center">
                <input class="text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg my-0" type="button" value="戻る" onclick="window.history.back()">
            </div>
        </div>
    </body>
</x-app-layout>