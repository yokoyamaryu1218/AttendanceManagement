<!-- admin側 復職・退職確認画面に出す従業員詳細画面のblade -->
@csrf
@method('post')
<div class="grid gap-6 mb-6 lg:grid-cols-2">
    <div>
        <!-- 社員番号 -->
        <label for="emplo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員番号</label>
        <input type="emplo_id" id="emplo_id" name="emplo_id" value="{{ $emplo->emplo_id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0000" readonly>
    </div>
    <div>
        <!-- 社員名 -->
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">社員名</label>
        <input type="text" id="name" name="name" value="{{ $emplo->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="山田太郎" readonly>
    </div>
</div>
<div class="grid gap-6 mb-6 lg:grid-cols-2">
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
</div>
<div class="grid gap-6 mb-12 lg:grid-cols-3">
    <div>
        <!-- 始業時間 -->
        <label for="restraint_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">始業時間</label>
        <input type="time" id="restraint_start_time" name="restraint_start_time" value="{{ $emplo->restraint_start_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10:00" readonly>
    </div>
    <div>
        <!-- 終業時間 -->
        <label for="restraint_closing_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">終業時間</label>
        <input type="time" id="restraint_closing_time" name="restraint_closing_time" value="{{ $emplo->restraint_closing_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="15:00" readonly>
    </div>
    <div>
        <!-- 就業時間 -->
        <label for="restraint_total_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">就業時間</label>
        <input type="time" id="restraint_total_time" name="restraint_total_time" value="{{ $emplo->restraint_total_time }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="5:00" readonly>
    </div>
</div>
<!-- ボタン配置 -->
<div class="flex justify-center">
<button type="submit" class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">実行</button>
                    <input class="flex mx-auto text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" onclick="window.history.back()">
</div>
<!-- ボタンここまで -->
