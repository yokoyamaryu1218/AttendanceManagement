<!-- admin側　勤怠一覧メイン部分のblade -->
<table class="table table-sm table-dark mb-2">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">・出勤日数：{{ $total_data['total_days'] }}日</th>
            <th scope="col">・総勤務時間：{{ $total_data['total_achievement_time'] }}</th>
            <th scope="col">・残業時間：{{ $total_data['total_over_time'] }}</th>
        </tr>
    </thead>
</table>

<table class="table-auto w-full text-left whitespace-no-wrap">
    <thead>
        <tr>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tl rounded-bl">日</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">出勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">退勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">休憩</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">実績</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">残業</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">日報</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tr rounded-br"></th>
        </tr>
    </thead>
    <tbody>
        <!-- 勤怠の情報取得 -->
        <?php for ($i = 1; $i <= $day_count; $i++) : ?>

            <?php
            $start_time = '';
            $closing_time = '';
            $rest_time = '';
            $achievement_time = '';
            $over_time = '';
            $daily = '';
            $daily_long = '';

            if (isset($monthly_data[date('Y-m-d', strtotime($ym . '-' . $i))])) {
                $work = $monthly_data[date('Y-m-d', strtotime($ym . '-' . $i))];
                if ($work['start_time']) {
                    $start_time = date('H:i', strtotime($work['start_time']));
                }
                if ($work['closing_time']) {
                    $closing_time = date('H:i', strtotime($work['closing_time']));
                }
                if ($work['rest_time']) {
                    $rest_time = date('H:i', strtotime($work['rest_time']));
                }
                if ($work['achievement_time']) {
                    $achievement_time = date('H:i', strtotime($work['achievement_time']));
                }
                if ($work['over_time']) {
                    $over_time = date('H:i', strtotime($work['over_time']));
                }
                if (nl2br($work['daily'])) {
                    $daily = mb_strimwidth($work['daily'], 0, 40, '...');
                    $daily_long = $work['daily'];
                }
            }
            ?>
            <!-- 勤怠の情報取得ここまで -->

            <!-- 勤怠の情報表示 -->
            <tr>
                <th scope="row" class="fix-col">{{ $format->time_format_dw($ym . '-' . $i) }}</th>
                <td class="fix-col">{{ $start_time }}</td>
                <td class="fix-col">{{ $closing_time }}</td>
                <td class="fix-col">{{ $rest_time }}</td>
                <td class="fix-col">{{ $achievement_time }}</td>
                <td class="fix-col">{{ $over_time }}</td>
                <td>
                    <div data-name="foo">{{ $daily }}</div>
                </td>
                <td>
                    <!-- モーダルここから -->
                    <script src="{{ asset('js/modal/modal2.js') }}" defer></script>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#inputModal" data-bs-name="{{ $name }}" data-bs-id="{{ $emplo_id }}" data-bs-day="{{ ($ym . '-' . sprintf('%02d', $i)) }}" data-bs-month="{{ date('n', strtotime($ym . '-' . $i)) }}/{{ $format->time_format_dw($ym . '-' . $i) }}" data-bs-start="{{ $start_time }}" data-bs-closing="{{ $closing_time }}" data-bs-daily="{{ $daily_long }}">
                        <img src="data:image/png;base64,{{Config::get('base64.pen')}}">
                    </button>
                    <!-- モーダルここまで -->
                </td>
            </tr>
            <!-- 勤怠の情報表示ここまで -->
        <?php endfor; ?>
    </tbody>
</table>
