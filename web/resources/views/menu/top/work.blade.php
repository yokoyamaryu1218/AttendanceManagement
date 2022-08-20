<!-- 出勤画面のblade -->
<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <!-- 日付表示部分 -->
            <div class="font-bold text-left text-2xl mb-5">{{ $ym }}/{{ $format->time_format_dw($today) }}</div>
            <!-- 日付表示ここまで -->
            <!-- メッセージ表示部分 -->
            <!-- 名前は7文字までだったら、1行で表示できる -->
            <div class="text-right mb-5">{{ $message }}</div>
            <!-- メッセージ表示部分ここまで -->
            <!-- 時間表示部分 -->
            <script src="{{ asset('js/time/time.js') }}" defer></script>
            <h1 class="font-bold text-center text-2xl mb-5" id="RealtimeClockArea2"></h1>
            <!-- 時間表示ここまで -->
            <!-- フラッシュメッセージの表示 -->
            @if (session('works_warning'))
            <div class="alert text-center alert-warning">
                {{ session('works_warning') }}
            </div>
            @endif
            @if (session('works_status'))
            <div class="alert text-center alert-info">
                {{ session('works_status') }}
            </div>
            @endif
            <!-- 出勤時は退勤ボタンを押せない状態にして、退勤時は出勤ボタンを押せなくしている -->
            <!-- 出勤ボタンここから -->
            <div class="flex justify-center">
                @if(!(isset($start_time[0])))
                <form method="POST" class="flex mx-auto" action="{{ route('employee.start_time_store')}}" name="start_time_store">
                    @csrf
                    <input type="hidden" class="form-control" id="modal_start_time" name="modal_start_time">
                    <button id="start_btn" class="text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすると出勤時間が登録されます。">出勤</button>
                </form>
                @else
                <button id="start_btn" disabled class="flex mx-auto text-white bg-green-100 border-0 py-2 px-8 focus:outline-none rounded text-lg" title="出勤済みのためボタンを押せません">出勤</button>
                @endif
                <!-- 出勤ボタンここまで -->
                <!-- 退勤ボタンここから -->
                @if($check_date == true)
                <form method="POST" class="flex mx-auto" action="{{ route('employee.closing_time_store')}}" name="end_time_store">
                    @csrf
                    <input type="hidden" class="form-control" id="modal_end_time" name="modal_end_time">
                    <button id="end_btn" class="text-white bg-orange-500 border-0 py-2 px-8 focus:outline-none hover:bg-orange-600 rounded text-lg" title="ボタンをクリックすると退勤時間が登録されます。">退勤</button>
                </form>
                @else
                <button id="end_btn" disabled class="flex mx-auto text-white bg-orange-100 border-0 py-2 px-8 focus:outline-none rounded text-lg" title="出勤時間が未打刻の場合はボタンを押せません。">退勤</button>
                @endif
            </div>
            <!-- 退勤ボタンここまで -->
        </div>
</section>
