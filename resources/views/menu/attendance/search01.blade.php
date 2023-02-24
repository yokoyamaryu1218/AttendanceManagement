<!-- employee側 期間勤怠合計検索のblade -->
<div class="text-right mb-1">
    <button class="title text-white bg-green-500 border-0 py-2 px-8 focus:outline-none hover:bg-green-600 rounded text-lg" style="width:105px;" title="ボタンをクリックすることで、指定期間内の出勤日数・総勤務時間・残業時間の検索画面が表示されます。">
    出力
    </button>
    <div class="box">
        <form method="POST" action="{{ route('employee.monthly_excel',[$emplo_id,$name] )}}" name="monthly_change">
            @csrf
            指定期間内の始業時間、<br class="sma">終業時間、<br class="sma">労働時間をExcelシートに出力します。</BR>
            <input type="date" id="first_day" name="first_day" value="{{ old('first_day') }}" required>
            ～ <input type="date" id="end_day" name="end_day" value="{{ old('end_day') }}" required>
            <button class="main_button_style" data-toggle="tooltip" type="submit">
                <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索" title="ボタンをクリックすることで、検索が行われます。">
            </button>
        </form>
    </div>
</div>