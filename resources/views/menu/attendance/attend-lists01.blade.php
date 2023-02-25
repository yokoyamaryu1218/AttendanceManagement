<!-- employee側　勤怠一覧メイン部分のblade -->
<div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class=" tbl-r06 w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase text-center dark:text-gray-400">
            <tr class="thead">
                <th class="bg-gray-100 dark:bg-gray-800" width="100">日</th>
                <th width="100">出勤</th>
                <th class="bg-gray-100 dark:bg-gray-800" width="100">退勤</th>
                <th width="100">休憩</th>
                <th class="bg-gray-100 dark:bg-gray-800" width="100">実績</th>
                <th width="100">残業</th>
                <th class="bg-gray-100 dark:bg-gray-800" width="550">日報</th>
                <th class="bg-gray-100 dark:bg-gray-800" width="120"></th>
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
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td scope="row" class="font-medium text-gray-900 whitespace-nowrap bg-gray-100 dark:text-white dark:bg-gray-800" width="100">
                        {{ $format->time_format_dw($ym . '-' . $i) }}
                    </td>
                    @if($start_time)
                    <td data-label="出勤" width="100">{{ $start_time }}</td>
                    <td class="bg-gray-100 dark:bg-gray-800" data-label="退勤" width="100">{{ $closing_time }}</td>
                    <td data-label="休憩" width="100">{{ $rest_time }}</th>
                    <td class="bg-gray-100 dark:bg-gray-800" data-label="実績" width="100">{{ $achievement_time }}</td>
                    <td data-label="残業" width="100">{{ $over_time }}</th>
                    <td class="bg-gray-100 dark:bg-gray-800" data-label="日報" width="550">{{ $daily }}</td>
                    @else
                    <td></td>
                    <td class="bg-gray-100 dark:bg-gray-800"></td>
                    <td></td>
                    <td class="bg-gray-100 dark:bg-gray-800"></td>
                    <td></td>
                    <td class="bg-gray-100 dark:bg-gray-800"></td>
                    @endif
                    <td class="bg-gray-100 dark:bg-gray-800">
                        <!-- モーダルへ情報を渡す -->
                        <!-- 自分自身の勤怠一覧の場合、日報表示のモーダルを表示 -->
                        @if (Auth::guard('employee')->user()->emplo_id == $emplo_id)
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-month="{{ date('n', strtotime($ym . '-' . $i)) }}" data-bs-day="{{ $format->time_format_dw($ym . '-' . $i) }}" data-bs-daily="{{ $daily_long }}" title="ボタンをクリックすることで、日報の内容を確認できます。">
                            <img src="data:image/png;base64,{{Config::get('base64.musi')}}">
                        </button>
                        <script src="{{ asset('js/modal/employeeModal.js') }}" defer></script>
                        @else
                        <!-- 部下の勤怠一覧の場合、勤怠修正のモーダル表示 -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#inputModal" data-bs-name="{{ $name }}" data-bs-id="{{ $emplo_id }}" data-bs-month="{{ date('n', strtotime($ym . '-' . $i)) }}/{{ $format->time_format_dw($ym . '-' . $i) }}" data-bs-day="{{ ($ym . '-' . sprintf('%02d', $i)) }}" data-bs-start="{{ $start_time }}" data-bs-closing="{{ $closing_time }}" data-bs-daily="{{ $daily_long }}" title="ボタンをクリックすることで、選択月日の勤怠修正画面を開きます。">
                            <img src="data:image/png;base64,{{Config::get('base64.pen')}}">
                        </button>
                        <script src="{{ asset('js/modal/topModal.js') }}" defer></script>
                        <!-- モーダルここまで -->
                        @if($start_time)
                        <button type="button" onclick="if(confirm('「{{ date('n', strtotime($ym . '-' . $i)) }}/{{ $format->time_format_dw($ym . '-' . $i) }}」の勤怠情報を削除します。よろしいですか？')) {window.location='{{ route('employee.monthly_delete', [$emplo_id, $name, ($ym . '-' . sprintf('%02d', $i))]) }}';}" title="ボタンをクリックすることで、選択月日の勤怠情報を削除できます。">
                            <img src="data:image/png;base64,{{Config::get('base64.dust')}}">
                        </button>
                        @else
                        <button title="勤怠情報がないので、削除ボタンは押せません。">
                            <img src="data:image/png;base64,{{Config::get('base64.dust_none')}}">
                        </button>
                        @endif
                        @endif
                    </td>
                </tr>
                <!-- 勤怠の情報表示ここまで -->
            <?php endfor; ?>
            <!-- モーダルのjs -->
        </tbody>
    </table>
</div>