<?php

namespace App\Libraries\php\Domain;
use App\Libraries\php\Domain\DataBase;

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
    public static function total_time($start_time, $closing_time, $restraint_start_time)
    {

        //就業開始時間よりも早く出勤していた場合は、就業開始時間から総勤務時間を求める
        if ($start_time < $restraint_start_time) {
            $start_time = $restraint_start_time;
        };

        $work_time_sec = strtotime($closing_time) - strtotime($start_time);              //退勤時間から開始時間を引いて、勤務時間(秒)を求める
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
    public static function rest_time($total_time)
    {
        $rest_time = DataBase::getRestTime();

        if ($total_time > $rest_time[0]->total_time1) { //8時間以上の場合は1時間
            $rest_time = $rest_time[0]->rest_time1;
        } elseif ($total_time > $rest_time[0]->total_time2) { //6時間を超える場合は45分
            $rest_time = $rest_time[0]->rest_time2;
        } else {
            $rest_time = $rest_time[0]->rest_time3;
        }

        return $rest_time;
    }

    /**
     * 実績時間を求める
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function achievement_time($total_time, $rest_time)
    {
        $work_time_sec =  strtotime($total_time) - strtotime($rest_time);
        $work_time_hour = floor($work_time_sec / 3600);                              //勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);       //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
        $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60); //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
        $achievement_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

        return $achievement_time;
    }

    /**
     * 残業時間を求める
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function over_time($achievement_time, $restraint_total_time)
    {
        //退勤打刻時間と就業終業時間を比較する
        if (strtotime($achievement_time) > strtotime($restraint_total_time)) {
            $work_time_sec =  strtotime($achievement_time) - strtotime($restraint_total_time);
            $work_time_hour = floor($work_time_sec / 3600);                              //勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
            $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);       //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
            $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60); //勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
            $over_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

            return $over_time;
        }
        $over_time = '00:00:00';
        return $over_time;
    }
}
