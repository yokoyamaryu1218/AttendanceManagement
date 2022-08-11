<!-- 絞り込み結果を表示するblade -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <body>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-4 mt-20 mx-auto">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <!-- 名前表示部分 -->
                    {{ $name }}さん
                    <!-- 名前表示部分ここまで -->
                    <!-- 絞り込み部分 -->
                    @include('menu.attendance.search03')
                    <!-- 絞り込み部分ここまで -->
                    <!-- フラッシュメッセージの表示 -->
                    @include('menu.attendance.validation')
                    <!-- フラッシュメッセージここまで -->
                    ・検索期間：{{$first_day}}～{{$end_day}}
                    <!-- 勤怠一覧の合計表示部分 -->
                    @include('menu.attendance.search02')
                    <!-- 合計表示部分ここまで -->
                    <div class="text-center">
                        <input class="btn btn-warning" type="button" value="戻る" onclick="window.history.back()">
                    </div>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>