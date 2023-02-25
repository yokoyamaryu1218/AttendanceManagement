<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <div class="max-w-2xl mx-auto my-3 bg-gray-100 p-16">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-4xl text-2xl font-medium title-font mb-2 text-gray-900">管理画面</h1>
            </div>

            <dl>
                <!-- フラッシュメッセージの表示 -->
                @include('menu.attendance.validation')

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
                <!-- フラッシュメッセージここまで -->
                <dt class="mb-2">・始業時間・終業時間一括変更</dt>
                <div class="sm:text-base text-sm">
                    <dd class="mb-2">時短勤務以外の全社員の始業時間・<BR class="sma">終業時間を一括で変更を行います。</dd>
                </div>

                <form method="POST" action="{{ route('admin.update_management') }}">
                    @csrf
                    <div class="grid gap-6 mb-12 lg:grid-cols-3">
                        <div>
                            <!-- 始業時間 -->
                            <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="始業時間を選択します。">始業時間</label>
                            <input type="time" id="restraint_start_time" name="restraint_start_time" value="{{ $working_hours[0]->restraint_start_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <!-- 終業時間 -->
                            <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="終業時間を選択します。">終業時間</label>
                            <input type="time" id="restraint_closing_time" name="restraint_closing_time" value="{{ $working_hours[0]->restraint_closing_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div>
                            <label></label>
                            <button type="submit" class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、登録されます。">変更</button>
                        </div>
                    </div>
                </form>

                <dt class="mb-2">・社員名簿ダウンロード(.xlsx)</dt>
                <div class="sm:text-base text-sm">
                    <form method="POST" action="{{ route('admin.employeeListDownload') }}">
                        @csrf
                        <div class="grid gap-6 mb-12 lg:grid-cols-2">
                            <div>
                                <button type="submit" class="flex flex-col justify-center items-center mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、登録されます。" style="height: 44px;">
                                    ダウンロード
                                </button>
                            </div>
                            <div>
                                <input type="checkbox" name="retirement_authority" id="retirement_authority" checked>退職済みの社員を含む
                            </div>
                        </div>
                    </form>
                </div>
            </dl>

            <section class="text-gray-600 text-center body-font relative">
</x-app-layout>