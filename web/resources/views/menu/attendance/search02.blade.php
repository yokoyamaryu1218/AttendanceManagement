<!-- 勤怠一覧の合計を表示するblade -->
<table class="table table-sm table-dark mb-2">
    <thead>
        <tr>
            @if($total_data['total_days'])
            <th scope="col"></th>
            <th scope="col">・出勤日数：{{ $total_data['total_days'] }}日</th>
            <th scope="col">・総勤務時間：{{ $total_data['total_achievement_time'] }}</th>
            <th scope="col">・残業時間：{{ $total_data['total_over_time'] }}</th>
            @else
            <th scope="col"></th>
            <th scope="col">・出勤日数：0日</th>
            <th scope="col">・総勤務時間：00:00:00</th>
            <th scope="col">・残業時間：00:00:00</th>
            @endif
        </tr>
    </thead>
</table>