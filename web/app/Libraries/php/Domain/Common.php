<?php

namespace App\Libraries\php\Domain;

/**
 * 記載が重複するものをまとめたクラス
 */

class Common
{
    /**
     * 曜日を表示する
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function time_format_dw($date)
    {
        $format_date = NULL;
        $week = array('日', '月', '火', '水', '木', '金', '土');

        if ($date) {
            $format_date = date('j (' . $week[date('w', strtotime($date))] . ')', strtotime($date));
        }

        return $format_date;
    }

    /**
     * 今月の年月を表示する
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    function to_monthly()
    {
        // https://codeforfun.jp/php-calendar/
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // 今月の年月を表示
            $ym = date('Y-m');
        }

        return $ym;
    }

    /**
     * 今月の年月を表示する
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    function top_monthly()
    {
        // https://codeforfun.jp/php-calendar/
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // 今月の年月を表示
            $ym = date('Y/m');
        }

        return $ym;
    }

    /**
     * 従業員情報を登録するクラス
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        // 人員を登録
        DataBase::insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority);

        // 就業時間を登録
        DataBase::insertOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time);

        //階層に登録
        DataBase::insertHierarchy($emplo_id, $management_emplo_id);
    }

    /**
     * 従業員情報を更新するクラス
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        // 人員を更新
        DataBase::updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority);

        // 就業時間を更新
        DataBase::updateOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time);

        //階層に更新
        DataBase::updateHierarchy($management_emplo_id, $emplo_id);
    }
}
