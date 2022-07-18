<script src="{{ asset('js/time/time.js') }}" defer></script>
<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto ">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <!-- 日付表示部分 -->
            <div class="font-bold text-left text-2xl mb-5">{{ $ym }}-{{ $format->time_format_dw($today) }}</div>
            <!-- 日付表示ここまで -->
            <!-- メッセージ表示部分 -->
            <div class="text-right mb-5">{{ $message }}</div>
            <!-- メッセージ表示部分ここまで -->
            <!-- 時間表示部分 -->
            <h1 class="font-bold text-center text-2xl mb-5" id="RealtimeClockArea2"></h1>
            <!-- 時間表示ここまで -->
            <div class="flex justify-center">
                <button class="flex mx-auto text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg">出勤</button>
                <button class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">退勤</button>
            </div>
            <div class="pt-6 w-full text-right">
                <button class="text-white bg-indigo-500 border-0 py-1 px-4 focus:outline-none hover:bg-indigo-600 rounded text-lg">出退勤切替</button>
            </div>
        </div>
</section>