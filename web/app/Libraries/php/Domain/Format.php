<?php

namespace App\Libraries\php\Domain;

use PDO;

/**
 * フォーマットを設定するクラス
 */

class Format
{
    // 曜日表示
    function time_format_dw($date)
    {
        $format_date = NULL;
        $week = array('日', '月', '火', '水', '木', '金', '土');

        if ($date) {
            $format_date = date('j(' . $week[date('w', strtotime($date))] . ')', strtotime($date));
        }

        return $format_date;
    }

    // 今月の年月を表示
    function to_monthly()
    {
        // https://codeforfun.jp/php-calendar/
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            $ym = date('Y-m');
        }

        return $ym;
    }
}
