<?php

namespace App\Libraries;

use App\Libraries\Database;
use Illuminate\Support\Facades\Auth;

/**
 * 勤務時間動作クラス
 */

class Time
{
    /**
     * 勤怠を新規登録するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $start_time 出勤時間
     * @param  int  $closing_time 退勤時間
     * @param  int  $target_date 選択した日付
     *
     * @var App\Libraries\php\Domain\Database
     * @var App\Libraries\php\Domain\Time
     * @var array $restraint_time 就業時間
     * @var array $total_time 総勤務時間
     * @var array $rest_time 休憩時間
     * @var array $achievement_time 実績時間
     * @var array $over_time 残業時間
     */
    public static function insertTime($emplo_id, $start_time, $closing_time, $target_date)
    {
        //休憩時間を求めるため、総勤務時間を求める
        $restraint_time = Database::getRestraintTime($emplo_id);
        $total_time = Time::total_time($start_time, $closing_time, $restraint_time[0]->restraint_start_time);

        //休憩時間を求める
        $rest_time = Time::rest_time($total_time);

        //実績時間を求める
        $achievement_time = Time::achievement_time($total_time, $rest_time);

        // 残業時間を求める
        $over_time = Time::over_time($achievement_time, $restraint_time[0]->restraint_total_time);

        // データベースに登録する
        try {
            Database::insertStartTime($emplo_id, $target_date, $start_time);
            Database::insertEndTime($closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };
    }

    /**
     * 勤怠を更新するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $start_time 出勤時間
     * @param  int  $closing_time 退勤時間
     * @param  int  $target_date 選択した日付
     *
     * @var App\Libraries\php\Domain\Database
     * @var App\Libraries\php\Domain\Time
     * @var array $restraint_time 就業時間
     * @var array $total_time 総勤務時間
     * @var array $rest_time 休憩時間
     * @var array $achievement_time 実績時間
     * @var array $over_time 残業時間
     */
    public static function updateTime($emplo_id, $start_time, $closing_time, $target_date)
    {
        //休憩時間を求めるため、総勤務時間を求める
        $restraint_time = Database::getRestraintTime($emplo_id);
        $total_time = Time::total_time($start_time, $closing_time, $restraint_time[0]->restraint_start_time);

        //休憩時間を求める
        $rest_time = Time::rest_time($total_time);

        //実績時間を求める
        $achievement_time = Time::achievement_time($total_time, $rest_time);

        // 残業時間を求める
        $over_time = Time::over_time($achievement_time, $restraint_time[0]->restraint_total_time);

        // データベースを更新する
        try {
            Database::updateTime($start_time, $closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };
    }


    /**
     * 日報の登録（更新）を行うクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $target_date 選択した日付
     * @param  int  $daily 日報
     * @param  int  $daily_data 日報データ
     *
     * @var App\Libraries\php\Domain\Database
     */
    public static function Daily($emplo_id, $target_date, $daily, $daily_data)
    {
        // 日報の登録がされていない場合は新規登録を行い
        if ($daily_data == NULL) {
            try {
                Database::insertDaily($emplo_id, $target_date, $daily);
            } catch (Exception $e) {
                $e->getMessage();
                if (Auth::guard('employee')->check()) {
                    return redirect()->route('employee.error');
                } elseif (Auth::guard('admin')->check()) {
                    return redirect()->route('employee.error');
                };
            };
        }
        // 日報が登録されている場合は更新処理を行う
        try {
            Database::updateDaily($emplo_id, $target_date, $daily);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };
    }

    /**
     * 就業時間を求める
     *
     * @param  int  $restraint_start_time 始業時間
     * @param  int  $restraint_closing_time 終業時間
     *
     * @var array $work_time_sec 退勤時間から開始時間を引いて、勤務時間(秒)を求める
     * @var array $work_time_hour 勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
     * @var array $work_time_min 勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $work_time_s /勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $restraint_total_time 就業時間
     *
     * @return  array $restraint_total_time
     */
    public static function restraint_total_time($restraint_start_time, $restraint_closing_time)
    {
        $work_time_sec =  strtotime($restraint_closing_time) - strtotime($restraint_start_time);
        $work_time_hour = floor($work_time_sec / 3600);
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);
        $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60);
        $restraint_total_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

        return $restraint_total_time;
    }


    /**
     * 休憩時間を求めるため、総勤務時間を求める
     * 参照：https://sukimanosukima.com/2020/07/18/php-6/
     *
     * @param  int  $start_time 出勤時間
     * @param  int  $closing_time 退勤時間
     * @param  int  $restraint_start_time 始業時間
     *
     * @var array $work_time_sec 退勤時間から開始時間を引いて、勤務時間(秒)を求める
     * @var array $work_time_hour 勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
     * @var array $work_time_min 勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $total_time 総勤務時間
     *
     * @return  array $total_time
     */
    public static function total_time($start_time, $closing_time, $restraint_start_time)
    {

        //就業開始時間よりも早く出勤していた場合は、就業開始時間から総勤務時間を求める
        if ($start_time < $restraint_start_time) {
            $start_time = $restraint_start_time;
        };

        $work_time_sec = strtotime($closing_time) - strtotime($start_time);
        $work_time_hour = floor($work_time_sec / 3600);
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);
        $total_time = $work_time_hour . '.' . $work_time_min;

        return $total_time;
    }

    /**
     * 休憩時間を求める
     *
     * @param  int  $todal_time 総勤務時間
     *
     * @var array $rest_time 休憩時間
     *
     * @return  array $rest_time
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
     *
     * @param  int  $todal_time 総勤務時間
     * @param  int  $rest_time 休憩時間
     *
     * @var array $work_time_sec 退勤時間から開始時間を引いて、勤務時間(秒)を求める
     * @var array $work_time_hour 勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
     * @var array $work_time_min 勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $work_time_s /勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $achievement_time 実績時間
     *
     * @return  array $achievement_time
     */
    public static function achievement_time($total_time, $rest_time)
    {
        $work_time_sec =  strtotime($total_time) - strtotime($rest_time);
        $work_time_hour = floor($work_time_sec / 3600);
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);
        $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60);
        $achievement_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

        return $achievement_time;
    }

    /**
     * 残業時間を求める
     *
     * @param  int  $achievement_time 実績時間
     * @param  int  $restraint_total_time 就業時間
     *
     * @var array $work_time_sec 退勤時間から開始時間を引いて、勤務時間(秒)を求める
     * @var array $work_time_hour 勤務時間(秒)を3600で割ると、時間を求め、小数点を切り捨てる
     * @var array $work_time_min 勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $work_time_s /勤務時間(秒)から時間を引いた余りを60で割ると、分を求め、小数点を切り捨てる
     * @var array $over_time 残業時間
     *
     * @return  array $over_time
     */
    public static function over_time($achievement_time, $restraint_total_time)
    {
        if (strtotime($restraint_total_time) > '8.0') { //8時間以上の場合は1時間
            $rest_time = '01:00:00';
        } elseif (strtotime($restraint_total_time) > '6.0') { //6時間を超える場合は45分
            $rest_time = '00:45:00';
        } else {
            $rest_time = '00:00:00';
        }

        $work_time_sec =  strtotime($restraint_total_time) - strtotime($rest_time);
        $work_time_hour = floor($work_time_sec / 3600);
        $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);
        $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60);
        $restraint_total_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

        //退勤打刻時間と就業終業時間を比較する
        if (strtotime($achievement_time) > strtotime($restraint_total_time)) {
            $work_time_sec =  strtotime($achievement_time) - strtotime($restraint_total_time);
            $work_time_hour = floor($work_time_sec / 3600);
            $work_time_min  = floor(($work_time_sec - ($work_time_hour * 3600)) / 60);
            $work_time_s    = $work_time_sec - ($work_time_hour * 3600 + $work_time_min * 60);
            $over_time = $work_time_hour . ':' . $work_time_min . ':' . $work_time_s;

            return $over_time;
        }
        $over_time = '00:00:00';
        return $over_time;
    }
}
