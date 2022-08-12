<!-- employee側 期間絞り込み検索のblade -->
<div class="text-right mb-1">
    <button class="title btn btn-secondary">絞り込み</button>
    <div class="box">
        <form method="POST" action="{{ route('employee.monthly_search',[$emplo_id,$name] )}}" name="monthly_change">
            @csrf
            <small><b>指定期間内の出勤日数・総勤務時間・残業時間を表示します。</b></small></BR>
            <input type="date" id="first_day" name="first_day" value="{{ old('first_day') }}">
            ～ <input type="date" id="end_day" name="end_day" value="{{ old('end_day') }}">
            <button class="main_button_style" data-toggle="tooltip" type="submit">
                <input class="main_button_img" type="image" src="data:image/png;base64,{{Config::get('base64.musi')}}" alt="検索">
            </button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/accordion.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/accordion.css') }}">