<!-- 勤怠一覧の合計を表示するblade -->
<div class="none text-center text-white bg-black mb-2">
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