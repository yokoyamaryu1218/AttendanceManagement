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

<!-- 勤怠一覧の合計を表示するblade -->
<div style="background-color: #CCCCCC;" class="grid gap-2 mb-2 lg:grid-cols-3">
    <tr>
        @if($total_data['total_days'])
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・出勤日数：{{ $total_data['total_days'] }}日</label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・総勤務時間：{{ $total_data['total_achievement_time'] }}</label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・残業時間：{{ $total_data['total_over_time'] }}</label>
        </div>
        @else
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・出勤日数：0日</label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・総勤務時間：00:00:00</label>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">・残業時間：00:00:00</label>
        </div>
        @endif
    </tr>
</div>