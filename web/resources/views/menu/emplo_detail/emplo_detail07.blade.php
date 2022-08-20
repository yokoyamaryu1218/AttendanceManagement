<!-- admin側 復職・退職確認画面に出す従業員詳細画面のblade -->
@csrf
@method('post')
<div class="grid gap-6 mb-6 lg:grid-cols-2">
    <div>
        <!-- 社員番号 -->
        <label for="emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の社員番号です。">社員番号</label>
        <input type="emplo_id" id="emplo_id" name="emplo_id" value="{{ $emplo->emplo_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0000" readonly>
    </div>
    <div>
        <!-- 社員名 -->
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の社員名です。">社員名</label>
        <input type="text" id="name" name="name" value="{{ $emplo->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
    </div>
</div>
<div class="grid gap-6 mb-6 lg:grid-cols-2">
    <div>
        <!-- 上司社員番号 -->
        <label for="management_emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の上司の社員番号です。">上司社員番号</label>
        <input type="text" id="management_emplo_id" name="management_emplo_id" maxlength="4" value="{{ $emplo->management_emplo_id }}" data-toggle="tooltip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1000" readonly>
    </div>
    <div>
        <!-- 上司の名前（現在） -->
        <label for="high_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の上司の名前（現在）です。">上司の名前（現在）</label>
        <input type="high_name" id="high_name" value="{{ $emplo->high_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
    </div>
</div>
<div class="grid gap-6 mb-12 lg:grid-cols-3">
    <div>
        <!-- 始業時間 -->
        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の始業時間です。">始業時間</label>
        <input type="time" id="restraint_start_time" name="restraint_start_time" value="{{ $emplo->restraint_start_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10:00" readonly>
    </div>
    <div>
        <!-- 終業時間 -->
        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"  title="選択した社員の終業時間です。">終業時間</label>
        <input type="time" id="restraint_closing_time" name="restraint_closing_time" value="{{ $emplo->restraint_closing_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="15:00" readonly>
    </div>
    <div>
        <!-- 退職日 -->
        @if(!($emplo->retirement_date))
        <label for="retirement_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="選択した社員の退職日です。">退職日</label>
        <input type="date" id="retirement_date" name="retirement_date" value="{{ old('retirement_date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        @else
        <label for="retirement_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" title="退職日を選択します。">退職日</label>
        <input type="date" id="retirement_date" name="retirement_date" value="{{ $emplo->retirement_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
        @endif
    </div>
</div>
<!-- ボタン配置 -->
<div class="flex justify-center">
    <button type="submit" class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、処理が実行されます。">実行</button>
    <input class="flex mx-auto text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" onclick="window.history.back()" title="1つ前の画面に戻ります。">
</div>
<!-- ボタンここまで -->
