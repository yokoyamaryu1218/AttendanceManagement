<!-- 参照先：https://tailwindcomponents.com/component/modal -->
<div class="main-modal fixed w-full h-300 inset-0 z-150 overflow-hidden flex justify-center items-center animated fadeIn faster" style="background: rgba(0,0,0,.7);">
    <div class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!-- Modal content -->
            <div class="relative">
                <!-- ここは×ボタン部分 -->
                <div class="flex justify-between">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">日付</label> <button type="button" class="modal-close bg-transparent ml-auto">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- ×ボタンここまで -->
                <!--ここから出勤退勤表示部分-->
                <div class="my-5">
                    <div class="flex mb-5">
                        <div class="flex-grow w-24 pr-5">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・出勤時間</label>
                            <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="出勤時間">
                        </div>
                        <div class="flex-grow w-24">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">・退勤時間</label>
                            <input type="text" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="退勤時間">
                        </div>
                    </div>
                    <!-- 出勤退勤部分ここまで -->
                    <!-- ここに日報が入る -->
                    <!-- textareaの枠はh-〇で調節ができる -->
                    <div class="relative">
                        <textarea id="message" name="message" class="w-full h-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ここに日報が入る"></textarea>
                    </div>

                    <!-- 日報部分ここまで -->
                </div>
                <!--Footer-->
                <!-- ここからボタン表示 -->
                <div class="flex justify-center">
                    <button class="focus:outline-none flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">更新</button>
                    <button class="focus:outline-none flex mx-auto modal-close text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">閉じる</button>
                </div>
                <!-- ボタン表示ここまで -->
            </div>
        </div>
    </div>
