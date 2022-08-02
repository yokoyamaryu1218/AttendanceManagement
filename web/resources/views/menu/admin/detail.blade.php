<!-- https://tailwindcomponents.com/component/input-field -->
<!-- 詳細画面のblade -->
<script src="{{ asset('js/admin/search.js') }}" defer></script>

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        @foreach($employee_lists as $emplo)
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">詳細画面</h1>
            </div>
            <form>
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <div>
                        <!-- 社員番号 -->
                        <label for="emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員番号</label>
                        <input type="emplo_id" id="emplo_id" value="{{ $emplo->emplo_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0000" readonly>
                    </div>
                    <div>
                        <!-- 社員名 -->
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員名</label>
                        <input type="text" id="name" value="{{ $emplo->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="山田太郎" required>
                    </div>
                    <div>
                        <!-- 部下参照権限 -->
                        <label for="subord_authority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">部下参照権限</label>
                        <label for="toggle-example" class="flex items-center cursor-pointer relative mb-4">
                        <input type="checkbox" id="toggle-example" class="sr-only" <?= $emplo->subord_authority == 1 ? 'checked' : '' ?>>
                            <div class="toggle-bg bg-gray-200 border-2 border-gray-200 h-6 w-11 rounded-full"></div>
                        </label>
                    </div>
                </div>
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <div>
                        <!-- 管理者番号 -->
                        <label for="management_emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">管理者番号</label>
                        <input type="text" id="management_emplo_id" name="management_emplo_id" maxlength="4" value="{{ $emplo->management_emplo_id }}" data-toggle="tooltip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1000" readonly>
                    </div>
                    <div>
                        <!-- 管理者名 -->
                        <label for="high_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">管理者名</label>
                        <input type="high_name" id="high_name" value="{{ $emplo->high_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="上司次郎" readonly>
                    </div>
                    <div>
                        <!-- 管理者検索 -->
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">管理者検索</label>
                        <input type="search" id="search-list" list="keywords" autocomplete="on" maxlength="4" data-toggle="tooltip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="管理者名を選択">
                        <datalist id="keywords">
                            @foreach($subord_authority_lists as $subord_authority_list)
                            <option value="{{$subord_authority_list->name}}" label="{{$subord_authority_list->emplo_id}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="grid gap-6 mb-12 lg:grid-cols-3">
                    <div>
                        <!-- 始業時間 -->
                        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">始業時間</label>
                        <input type="time" id="restraint_start_time" value="{{ $emplo->restraint_start_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10:00" required>
                    </div>
                    <div>
                        <!-- 終業時間 -->
                        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">終業時間</label>
                        <input type="time" id="restraint_closing_time" value="{{ $emplo->restraint_closing_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="15:00" required>
                    </div>
                    <div>
                        <!-- 就業時間 -->
                        <label for="restraint_total_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">就業時間</label>
                        <input type="time" id="restraint_total_time" value="{{ $emplo->restraint_total_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="5:00" required>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 flex mx-auto focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">更新</button>
                    <input class="btn btn-warning my-0" type="button" value="戻る" onclick="location.href='./';">
                </div>
            </form>
        </div>
        @endforeach
    </body>
</x-app-layout>