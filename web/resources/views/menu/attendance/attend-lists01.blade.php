<!-- employee側　勤怠一覧メイン部分のblade -->
<table class="tbl-r05 table-auto w-full text-left whitespace-no-wrap">
    <tr class="thead">
        <th width="100">日</th>
        <th width="100">出勤</th>
        <th width="100">退勤</th>
        <th width="100">休憩</th>
        <th width="100">実績</th>
        <th width="100">残業</th>
        <th width="550">日報</th>
        <th width="120"></th>
    </tr>
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
                <td scope="row"  width="100">{{ $format->time_format_dw($ym . '-' . $i) }}</td>
                @if($start_time)
                <td data-label="出勤"  width="100">{{ $start_time }}</td>
                <td data-label="退勤"  width="100">{{ $closing_time }}</td>
                <td data-label="休憩"  width="100">{{ $rest_time }}</td>
                <td data-label="実績"  width="100">{{ $achievement_time }}</td>
                <td data-label="残業"  width="100">{{ $over_time }}</td>
                <td data-label="日報"  width="550">{{ $daily }}</td>
                @else
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                @endif
                <td>
                    <!-- モーダルへ情報を渡す -->
                    <!-- 自分自身の勤怠一覧の場合、日報表示のモーダルを表示 -->
                    @if (Auth::guard('employee')->user()->emplo_id == $emplo_id)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-month="{{ date('n', strtotime($ym . '-' . $i)) }}" data-bs-day="{{ $format->time_format_dw($ym . '-' . $i) }}" data-bs-daily="{{ $daily_long }}">
                        <img src="data:image/png;base64,{{Config::get('base64.musi')}}">
                    </button>
                    @else

                    <!-- 部下の勤怠一覧の場合、勤怠修正のモーダル表示 -->
                    <button type="button" data-bs-toggle="modal" data-bs-target="#inputModal" data-bs-name="{{ $name }}" data-bs-id="{{ $emplo_id }}" data-bs-month="{{ date('n', strtotime($ym . '-' . $i)) }}/{{ $format->time_format_dw($ym . '-' . $i) }}" data-bs-day="{{ ($ym . '-' . sprintf('%02d', $i)) }}" data-bs-start="{{ $start_time }}" data-bs-closing="{{ $closing_time }}" data-bs-daily="{{ $daily_long }}">
                        <img src="data:image/png;base64,{{Config::get('base64.pen')}}">
                    </button>
                    @endif
                    <!-- モーダルここまで -->
                </td>
            </tr>
            <!-- 勤怠の情報表示ここまで -->
        <?php endfor; ?>
    </tbody>
</table>