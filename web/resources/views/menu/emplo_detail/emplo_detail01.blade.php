<!-- https://tailwindcomponents.com/component/input-field -->
<!-- admin側　従業員詳細画面のblade -->
<script src="{{ asset('js/admin/search.js') }}" defer></script>

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        @foreach($employee_lists as $emplo)
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">詳細画面</h1>
            </div>
            <div class="text-right">
                <!-- 退職フラグが0の場合は、退職ボタンを出し -->
                @if(($emplo->retirement_authority) == "0")
                <form method="get" action="{{ route('admin.destroy_check',[$emplo->emplo_id,$emplo->retirement_authority])}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn btn-danger border-0 py-2 px-8 focus:outline-none rounded text-lg">退職</button>
                </form>
                @else
                <!-- 退職フラグが1の場合は、復職ボタンを出す -->
                <form method="get" action="{{ route('admin.reinstatement_check',[$emplo->emplo_id,$emplo->retirement_authority])}}">
                    @csrf
                    <button class="input-group-text flex mx-auto text-white btn btn btn-primary border-0 py-2 px-8 focus:outline-none rounded text-lg">復職</button>
                </form>
                @endif
                <!-- ボタンここまで -->
            </div>
            <form method="POST" action="{{ route('admin.details_update') }}">
                @csrf
                @method('post')
                <!-- フラッシュメッセージの表示 -->
                @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->has('name'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('name') }}
                </div>
                @endif
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <div>
                        <!-- 社員番号 -->
                        <label for="emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員番号</label>
                        <input type="emplo_id" id="emplo_id" name="emplo_id" value="{{ $emplo->emplo_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    <div>
                        <!-- 社員名 -->
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員名</label>
                        <input type="text" id="name" name="name" value="{{ $emplo->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="山田太郎">
                    </div>
                    <div>
                        <!-- 部下参照権限 -->
                        <label for="subord_authority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">部下参照権限</label>
                        <label for="subord_authority" class="flex items-center cursor-pointer relative mb-4">
                            <input type="checkbox" onclick="clickBtn7()" id="subord_authority" name="subord_authority" class="sr-only" <?= $emplo->subord_authority == 1 ? 'checked' : '' ?>>
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
                        <input type="high_name" id="high_name" value="{{ $emplo->high_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
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
                @if ($errors->has('restraint_start_time'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('restraint_start_time') }}
                </div>
                @endif
                @if ($errors->has('restraint_closing_time'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('restraint_closing_time') }}
                </div>
                @endif
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <div>
                        <!-- 始業時間 -->
                        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">始業時間</label>
                        <input type="time" id="restraint_start_time" name="restraint_start_time" value="{{ $emplo->restraint_start_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10:00">
                    </div>
                    <div>
                        <!-- 終業時間 -->
                        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">終業時間</label>
                        <input type="time" id="restraint_closing_time" name="restraint_closing_time" value="{{ $emplo->restraint_closing_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="15:00">
                    </div>
                    <div>
                        <!-- 就業時間 -->
                        <label for="restraint_total_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">就業時間</label>
                        <input type="time" id="restraint_total_time" name="restraint_total_time" value="{{ $emplo->restraint_total_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="5:00" readonly>
                    </div>
                </div>
                <div class="grid gap-6 mb-12 lg:grid-cols-3">
                    <div>
                        <!-- 登録日時 -->
                        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">登録日時</label>
                        <input type="timestamp" id="ceated_at" name="created_at" value="{{ $emplo->created_at }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    <div>
                        <!-- 更新日時 -->
                        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">更新日時</label>
                        <input type="timestamp" id="updated_at" name="updated_at" value="{{ $emplo->updated_at }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    @if(isset($emplo->deleted_at))
                    <div>
                        <!-- 退職処理日時 -->
                        <label for="restraint_total_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">退職処理日時</label>
                        <input type="timestamp" id="deleted_at" name="deleted_at" value="{{ $emplo->deleted_at }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    @else
                    <div>
                        <!-- 入社日 -->
                        <label for="hire_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">入社日</label>
                        <input type="timestamp" id="hire_date" name="hire_date" value="{{ $emplo->hire_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                    </div>
                    @endif
                </div>
                <!-- ボタン配置 -->
                <div class="flex justify-center">
                <button type="submit" class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">更新</button>
                    <input class="flex mx-auto text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" onclick="window.history.back()">
                </div>
                <!-- ボタンここまで -->
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
