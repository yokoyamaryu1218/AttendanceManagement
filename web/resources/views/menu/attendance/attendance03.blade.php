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
                    <div class="none">・検索期間：{{$first_day}}～{{$end_day}}</div>
                    <small class="sma">・検索期間：{{$first_day}}～{{$end_day}}</small>
                    <!-- 勤怠一覧の合計表示部分 -->
                    <div class="text-center text-white bg-black mb-2">
                        <div class="grid gap-1 p-2 md:grid-cols-3">
                            @if($total_data['total_days'])
                            <div class="p-2">・出勤日数：{{ $total_data['total_days'] }}日</div>
                            <div class="p-2">・総勤務時間：{{ $total_data['total_achievement_time'] }}</div>
                            <div class="p-2">・残業時間：{{ $total_data['total_over_time'] }}</div>
                            @else
                            <div class="p-2">・出勤日数：0日</div>
                            <div class="p-2">・総勤務時間：00:00:00</div>
                            <div class="p-2">・残業時間：00:00:00</div>
                            @endif
                        </div>
                    </div>
                    <!-- 合計表示部分ここまで -->
                    <div class="text-center">
                        <input class="btn btn-warning" type="button" value="戻る" onclick="window.history.back()">
                    </div>
                </div>
            </div>
        </section>
    </body>
</x-app-layout>

<!-- 絞り込みメニューのcssとjs、ここに書かないと機能しない -->
<link rel="stylesheet" href="{{ asset('css/accordion.css') }}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
