<?php require_once(dirname(__FILE__) . '/function.php'); ?>
<table class="table-auto w-full text-left whitespace-no-wrap">
    <thead>
        <tr>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tl rounded-bl">日</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">出勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">退勤</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">休憩</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">実績</th>
            <th class="px-1 py-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100">業務内容</th>
            <th class="w-1 title-font tracking-wider font-medium text-gray-800 text-sm bg-gray-100 rounded-tr rounded-br"></th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 1; $i <= $day_count; $i++) : ?>

            <?php
            $start_time = '';
            $end_time = '';
            $lest_time = '';
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
                if ($work['lest_time']) {
                    $lest_time = date('H:i', strtotime($work['lest_time']));
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
                <th class="px-1 py-1">{{ time_format_dw($ym . '-' . $i) }}</th>
                <td class="px-1 py-1">{{ $start_time }}</td>
                <td class="px-1 py-1">{{ $end_time }}</td>
                <td class="px-1 py-1">{{ $lest_time }}</td>
                <td class="px-1 py-1">{{ $achievement_time }}</td>
                <td class="px-1 py-1">{{ $daily }}</td>
                <td class="w-1 text-center">
                    <a href="#">✏</a>
                </td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
