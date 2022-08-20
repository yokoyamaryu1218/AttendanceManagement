<!-- 勤怠合計結果を表示するblade -->
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
                    <!-- 勤怠合計部分 -->
                    @include('menu.attendance.search03')
                    <!-- 勤怠合計部分ここまで -->
                    <!-- フラッシュメッセージの表示 -->
                    @include('menu.attendance.validation')
                    <!-- フラッシュメッセージここまで -->
                    <div>検索期間　：{{$first_day}}～{{$end_day}}</div>
                    <!-- 勤怠一覧の勤怠合計部分 -->
                    @include('menu.attendance.search02')
                    <!-- 勤怠合計部分ここまで -->
                    <div class="text-center">
                        <input class="text-white bg-yellow-400 border-0 py-2 px-8 focus:outline-none hover:bg-yellow-300 rounded text-lg" type="button" value="戻る" onclick="window.history.back()" title="1つ前の画面に戻ります。">
                    </div>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>

<!-- 勤怠合計メニューのcssとjs、ここに書かないと機能しない -->
<link rel="stylesheet" href="{{ asset('css/accordion.css') }}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
