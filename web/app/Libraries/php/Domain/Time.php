<?php

namespace App\Libraries\php\Domain;

use App\Libraries\php\Domain\DataBase;

/**
 * 勤務時間動作クラス
 */

class Time
{
    /**
     * 勤怠を新規登録するクラス
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function insertTime($emplo_id, $start_time, $closing_time, $target_date)
    {
        //休憩時間を求めるため、総勤務時間を求める
        $cloumns_name = 'restraint_start_time';
        $restraint_start_time = Database::getOverTime($cloumns_name, $emplo_id);

        $cloumns_name = 'restraint_total_time';
        $restraint_total_time = Database::getOverTime($cloumns_name, $emplo_id);

        $total_time = Time::total_time($start_time, $closing_time, $restraint_start_time[0]->restraint_start_time);

        //休憩時間を求める
        $rest_time = Time::rest_time($total_time);

        //実績時間を求める
        $achievement_time = Time::achievement_time($total_time, $rest_time);

        // 残業時間を求める
        $over_time = Time::over_time($achievement_time, $restraint_total_time[0]->restraint_total_time);

        // データベースに登録する
        DataBase::insertTime($emplo_id, $target_date, $start_time, $closing_time, $rest_time, $achievement_time, $over_time);
    }

    /**
     * 勤怠を更新するクラス
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateTime($emplo_id, $start_time, $closing_time, $target_date)
    {
        //休憩時間を求めるため、総勤務時間を求める
        $cloumns_name = 'restraint_start_time';
        $restraint_start_time = Database::getOverTime($cloumns_name, $emplo_id);

        $cloumns_name = 'restraint_total_time';
        $restraint_total_time = Database::getOverTime($cloumns_name, $emplo_id);

        $total_time = Time::total_time($start_time, $closing_time, $restraint_start_time[0]->restraint_start_time);

        //休憩時間を求める
        $rest_time = Time::rest_time($total_time);

        //実績時間を求める
        $achievement_time = Time::achievement_time($total_time, $rest_time);

        // 残業時間を求める
        $over_time = Time::over_time($achievement_time, $restraint_total_time[0]->restraint_total_time);

        // データベースを更新する
        DataBase::updateTime($start_time, $closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date);
    }


    /**
     * 勤怠処理と合わせて日報の登録（更新）を行うクラス
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function Daily($emplo_id, $target_date, $daily, $daily_data)
    {
        // 日報の登録がされていない場合は新規登録を行い
        if ($daily_data == NULL) {
            DataBase::insertDaily($emplo_id, $target_date, $daily);
        }
        // 日報が登録されている場合は更新処理を行う
        DataBase::updateDaily($emplo_id, $target_date, $daily);
    }

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
        if ($total_time > '8.0') { //8時間以上の場合は1時間
            $rest_time = '01:00:00';
        } elseif ($total_time > '6.0') { //6時間を超える場合は45分
            $rest_time = '00:45:00';
        } else {
            $rest_time = '00:00:00';
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
