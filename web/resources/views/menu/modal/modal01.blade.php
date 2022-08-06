<!-- employee側 日報のmodal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- タイトル部分と×ボタンの表示 -->
            <div class="modal-header">
                <h5><label class="modal-title" for="modal-title"></label> 日報</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- タイトル部分と×ボタンの表示ここまで -->

            <!-- 日報の表示（編集は不可） -->
            <div class="modal-body">
                <div class="relative">
                    <textarea id="modal_daily" name="modal_daily" class="w-full h-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="日報"></textarea>
                </div>
            </div>
            <!-- 日報の表示ここまで -->

            <!-- ボタンの配置 -->
            <div class="flex justify-center modal-footer">
                <button type="button" class="focus:outline-none flex mx-auto modal-close text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg" data-bs-dismiss="modal">閉じる</button>
            </div>
            <!-- ボタンここまで -->
        </div>
    </div>
</div>
