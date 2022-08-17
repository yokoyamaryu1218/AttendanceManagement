<!-- モーダルの詳細部分のblade -->
<div class="modal-body">
    <div class="flex mb-3">
        <!-- 出勤時間 -->
        <div class="flex-grow w-24 pr-5">
            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・出勤時間</label>
            <input id="modal_start_time" name="modal_start_time" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="出勤時間" title="出勤時間を選択します。">
        </div>
        <!-- 出勤時間ここまで -->
        <!-- 退勤時間 -->
        <div class="flex-grow w-24">
            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・退勤時間</label>
            <input id="modal_closing_time" name="modal_closing_time" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="退勤時間" title="退勤時間を選択します。">
        </div>
        <!-- 退勤時間ここまで -->
    </div>
    <div class="relative">
        <!-- 日報 -->
        @if ($errors->has('daily'))
        <div class="alert text-center alert-warning">
            {{ $errors->first('daily') }}
        </div>
        @endif
        <textarea id="modal_daily" name="modal_daily" class="w-full h-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="日報" title="日報を編集できます。（1,024文字まで）"></textarea>
        <!-- 日報ここまで -->
    </div>

    <div class="flex justify-center modal-footer">
        <!-- ボタン配置 -->
        <button class="focus:outline-none flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、更新されます。">更新</button>
        <button type="button" class="focus:outline-none flex mx-auto modal-close text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg" data-bs-dismiss="modal" title="この画面を閉じます。">閉じる</button>
        <!-- ボタンここまで -->
    </div>
</div>
<!-- 以下勤怠一覧にリダイレクトしたときに必要な情報 -->
<input type="hidden" id="modal_name" name="modal_name">
<input type="hidden" id="modal_day" name="modal_day">
<input type="hidden" id="modal_id" name="modal_id">
