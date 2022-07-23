<table class="table-auto w-full text-left whitespace-no-wrap">
    <thead>
        <tr>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tl rounded-bl">日</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">出勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">退勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">休憩</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">実績</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">日報</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tr rounded-br"></th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 1; $i <= $day_count; $i++) : ?>

            <?php
            $start_time = '';
            $end_time = '';
            $rest_time = '';
            $achievement_time = '';
            $daily = '';

            if (isset($monthly_data[date('Y-m-d', strtotime($ym . '-' . $i))])) {
                $work = $monthly_data[date('Y-m-d', strtotime($ym . '-' . $i))];
                if ($work['start_time']) {
                    $start_time = date('H:i', strtotime($work['start_time']));
                }
                if ($work['end_time']) {
                    $end_time = date('H:i', strtotime($work['end_time']));
                }
                if ($work['rest_time']) {
                    $rest_time = date('H:i', strtotime($work['rest_time']));
                }
                if ($work['achievement_time']) {
                    $achievement_time = date('H:i', strtotime($work['achievement_time']));
                }
                if ($work['daily']) {
                    $daily = mb_strimwidth($work['daily'], 0, 40, '...');
                }
            }
            ?>

            <tr>
                <th scope="row" class="fix-col">{{ $format->time_format_dw($ym . '-' . $i) }}</th>
                <td class="fix-col">{{ $start_time }}</td>
                <td class="fix-col">{{ $end_time }}</td>
                <td class="fix-col">{{ $rest_time }}</td>
                <td class="fix-col">{{ $achievement_time }}</td>
                <td>
                    <div data-name="foo">{{ $daily }}</div>
                </td>
                <td>
                    <button type="button" onclick="openModal()" class="input_modal" data-bs-toggle="modal" data-bs-target="#inputModal" data-bs-daily="{{ $daily }}">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                        <img src="data:image/png;base64,{{Config::get('base64.musi')}}">
                    </button>
                </td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
