<!-- employee側 期間勤怠合計検索のblade -->
<div class="text-right mb-1">
    <button class="title text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" title="ボタンをクリックすることで、指定期間内の出勤日数・総勤務時間・残業時間の検索画面が表示されます。">勤怠合計</button>
    <div class="box">
        <form method="POST" action="{{ route('employee.monthly_search',[$emplo_id,$name] )}}" name="monthly_change">
            @csrf
            指定期間内の出勤日数、<br class="sma">総勤務時間、<br class="sma">残業時間を表示します。</BR>
            <input type="date" id="first_day" name="first_day" value="{{ old('first_day') }}">
            ～ <input type="date" id="end_day" name="end_day" value="{{ old('end_day') }}">
            <button class="main_button_style" data-toggle="tooltip" type="submit">
                <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索" title="ボタンをクリックすることで、検索が行われます。">
            </button>
        </form>
    </div>
</div>
