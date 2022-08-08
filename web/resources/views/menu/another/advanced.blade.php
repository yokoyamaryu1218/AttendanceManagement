<!-- https://tailwindcomponents.com/component/input-field -->
<!-- admin側　就業規則画面のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">就業規則(簡易版)</h1>
            </div>
            <form>
                <div class="grid gap-6 mb-6 lg:grid-cols-1">
                    ・就業時間は契約書に基づき、従業員ごとに定める。
                </div>
                <div class="grid gap-6 mb-6 lg:grid-cols-1">
                    ・休憩時間は、総勤務時間が8時間を超える場合は、1時間、
                </div>
                <div class="grid gap-6 mb-6 lg:grid-cols-1">
                    6時間を超え、8時間未満の場合は、45分とし、
                </div>
                <div class="grid gap-6 mb-12 lg:grid-cols-1">
                    6時間未満の場合は、休憩なしとする。
                </div>

                <div class="flex justify-center">
                    <input class="btn btn-warning my-0" type="button" value="戻る" onclick="window.history.back()">
                </div>
            </form>
        </div>
    </body>
</x-app-layout>
