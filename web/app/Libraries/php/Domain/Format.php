<?php

namespace App\Libraries\php\Domain;

use PDO;

/**
 * フォーマットを設定するクラス
 */

class Format
{
    function time_format_dw($date)
    {
        $format_date = NULL;
        $week = array('日', '月', '火', '水', '木', '金', '土');

        if ($date) {
            $format_date = date('j(' . $week[date('w', strtotime($date))] . ')', strtotime($date));
        }

        return $format_date;
    }
}
