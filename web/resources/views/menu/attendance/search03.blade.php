<!-- admin側 期間絞り込み検索のblade -->
<div class="text-right mb-1">
    <button class="title btn btn-secondary" title="ボタンをクリックすることで、指定期間内の出勤日数・総勤務時間・残業時間の検索画面が表示されます。">絞り込み</button>
    <div class="box">
        @if (Auth::guard('employee')->check())
        <form method="POST" action="{{ route('employee.monthly_search',[$emplo_id,$name] )}}" name="monthly_change">
            @elseif  (Auth::guard('admin')->check())
            <form method="POST" action="{{ route('admin.monthly_search',[$emplo_id,$name] )}}" name="monthly_change">
                @endif
                @csrf
                指定期間内の出勤日数、<br class="sma">総勤務時間、<br class="sma">残業時間を表示します。</BR>
                <input type="date" id="first_day" name="first_day" value="{{ old('first_day') }}">
                ～ <input type="date" id="end_day" name="end_day" value="{{ old('end_day') }}">
                <button class="main_button_style" data-toggle="tooltip" type="submit">
                    <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索">
                </button>
            </form>
    </div>
</div>
