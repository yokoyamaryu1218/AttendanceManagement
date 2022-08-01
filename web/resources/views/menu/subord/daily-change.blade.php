<!-- 出退勤変更モーダルのblade -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputexamplesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content flex justify-between">
            <div class="modal-header">
                <h5><label class="modal-title" for="modal-title"></label></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('employee.subord_monthly.update') }}" name="monthly.update">
                @csrf
                <div class="modal-body">
                    <div class="flex mb-3">
                        <div class="flex-grow w-24 pr-5">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・出勤時間</label>
                            <input id="modal_start_time" name="modal_start_time" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="出勤時間">
                        </div>
                        <div class="flex-grow w-24">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・退勤時間</label>
                            <input id="modal_closing_time" name="modal_closing_time" type="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="退勤時間">
                        </div>
                    </div>
                    <div class="relative">
                        <textarea id="modal_daily" name="modal_daily" class="w-full h-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="日報"></textarea>
                    </div>

                    <div class="flex justify-center modal-footer">
                        <button class="focus:outline-none flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">更新</button>
                        <button type="button" class="focus:outline-none flex mx-auto modal-close text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
                <input type="hidden" id="modal_day" name="modal_day">
                <input type="hidden" id="modal_id" name="modal_id">
            </form>
        </div>
    </div>
</div>
