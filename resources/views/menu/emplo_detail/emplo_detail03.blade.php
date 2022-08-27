<!-- admin側　従業員新規登録画面のblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">新規登録画面</h1>
            </div>
            <form method="POST" action="{{ route('admin.emplo_store')}}">
                @csrf
                @method('post')
                @if ($errors->has('name'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('name') }}
                </div>
                @endif
                @if ($errors->has('password'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('password') }}
                </div>
                @endif
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <div>
                        <!-- 社員名 -->
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="社員名を入力します。">社員名</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" autocomplete="off" placeholder="ここに名前を入力">
                    </div>
                    <div>
                        <!-- パスワード -->
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="勤怠システム用のパスワードを英数混合8文字以上で設定します。">パスワード</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="●●●●●●●●" required autocomplete="current-password">
                        <input type="checkbox" id="password-check">パスワードを表示する
                    </div>
                    <script src="{{ asset('/js/another/auth.js') }}"></script>
                    <div>
                        <!-- 部下配属権限 -->
                        <label for="subord_authority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="トグルをONにすると、選択した社員に部下を配属することができます。">部下配属権限</label>
                        <label for="subord_authority" class="flex items-center cursor-pointer relative mb-4">
                            <input type="checkbox" onclick="clickBtn7()" id="subord_authority" name="subord_authority" class="sr-only">
                            <div class="toggle-bg bg-gray-200 border-2 border-gray-200 h-6 w-11 rounded-full"></div>
                        </label>
                    </div>
                </div>
                @if ($errors->has('management_emplo_id'))
                <div class="alert text-center alert-warning">
                    {{ $errors->first('management_emplo_id') }}
                </div>
                @endif
                <div class="grid gap-6 mb-6 lg:grid-cols-2">
                    <div>
                        <!-- 上司社員番号 -->
                        <label for="management_emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="上司の社員番号です。">上司社員番号</label>
                        <input type="text" id="management_emplo_id" name="management_emplo_id" maxlength="4" value="{{ old('managment_emplo_id') }}" data-toggle="tooltip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="上司検索をすることで反映します" readonly>
                    </div>
                    <div>
                        <!-- 上司検索 -->
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="新規登録する社員の上司を検索します。">上司検索</label>
                        <input type="search" id="search-list" list="keywords" autocomplete="off" data-toggle="tooltip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="上司の名前を選択">
                        <datalist id="keywords">
                            @foreach($subord_authority_lists as $subord_authority_list)
                            <option value="{{$subord_authority_list->name}}" label="{{$subord_authority_list->emplo_id}}"></option>
                            @endforeach
                        </datalist>
                        <script src="{{ asset('js/another/search.js') }}" defer></script>
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
                <div class="grid gap-6 mb-12 lg:grid-cols-3">
                    <div>
                        <!-- 始業時間 -->
                        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="始業時間を選択します。">始業時間</label>
                        <input type="time" id="restraint_start_time" name="restraint_start_time" value="{{ old('restraint_start_time') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div>
                        <!-- 終業時間 -->
                        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="終業時間を選択します。">終業時間</label>
                        <input type="time" id="restraint_closing_time" name="restraint_closing_time" value="{{ old('restraint_closing_time') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div>
                        <!-- 入社日 -->
                        <label for="hire_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="入社日を選択します。">入社日</label>
                        <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
                <!-- ボタン配置 -->
                <div class="flex justify-center">
                    <button type="submit" class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、登録されます。">登録</button>
                    <input id="myButton" class="flex mx-auto text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" title="HOME画面に戻ります。">
                </div>
                <!-- ボタンここまで -->
            </form>
        </div>
    </body>
    <!-- 戻るボタンの遷移先 -->
    <script type="text/javascript">
        document.getElementById("myButton").onclick = function() {
            location.href = "{{ route('admin.dashboard') }}";
        };
    </script>
</x-app-layout>
