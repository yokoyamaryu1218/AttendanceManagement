<?php

namespace App\Libraries\php\Domain;

/**
 * 勤務時間動作クラス
 */

class Time
{
    /**
     * 休憩時間を求めるため、総勤務時間を求める
     * 参照：https://sukimanosukima.com/2020/07/18/php-6/
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function total_time($start_time, $end_time)
    {

        $work_time_sec = strtotime($end_time) - strtotime($start_time);              //退勤時間から開始時間を引いて、勤務時間(秒)を求める
        $work_time_hour = floor($work_time_sec / 3600);                              //勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);       //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
        $total_time = $work_time_hour . '.' . $work_time_min;

        return $total_time;
    }

    /**
     * 休憩時間を求める
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function lest_time($total_time)
    {
        if ($total_time > '8.0') { //8時間以上の場合は1時間
            $lest_time = '01:00:00';
        } elseif ($total_time > '6.0') { //6時間を超える場合は45分
            $lest_time = '00:45:00';
        } else {
            $lest_time = '00:00:00';
        }

        return $lest_time;
    }

    /**
     * 実績時間を求める
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function achievement_time($total_time, $lest_time)
    {
        $work_time_sec =  strtotime($total_time) - strtotime($lest_time);
        $work_time_hour = floor($work_time_sec / 3600);                              //勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);       //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
        $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60); //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
        $achievement_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

        return $achievement_time;
    }
}