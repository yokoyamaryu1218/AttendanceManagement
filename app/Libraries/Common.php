<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

/**
 * 記載が重複するものをまとめたクラス
 */

class Common
{
    /**
     * 曜日を表示する
     * @param  int  $date 日付
     *
     * @var array $week 曜日
     * @var array $format_date 曜日を表示するフォーマットデータ
     *
     * @return  array $format_date
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
     *
     * @var string $ym 今月の年月
     *
     * @return  array $ym
     */
    function to_monthly()
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
     * 従業員情報を登録するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $name 社員名
     * @param  int  $password パスワード
     * @param  int  $managment_emplo_id 上司社員番号
     * @param  int  $subord_authority 部下配属権限
     * @param  int  $retirement_authority 退職フラグ
     * @param  int  $hire_date 入社日
     * @param  int  $restraint_start_time 始業時間
     * @param  int  $restraint_closing_time 終業時間
     * @param  int  $restraint_total_time 所定労働時間
     * @param  int  $short_working 時短フラグ
     * @var App\Libraries\php\Domain\Database
     */
    public static function insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date, $restraint_start_time, $restraint_closing_time, $restraint_total_time, $short_working)
    {
        try {
            // 人員を登録
            DB::beginTransaction();
            Database::insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date);

            // 所定労働時間を登録
            Database::insertOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time, $short_working);

            //階層に登録
            Database::insertHierarchy($emplo_id, $management_emplo_id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $e->getMessage();
            return redirect()->route('admin.error');
        };
    }

    /**
     * 従業員情報を更新するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $name 社員名
     * @param  int  $managment_emplo_id 上司社員番号
     * @param  int  $subord_authority 部下配属権限
     * @param  int  $retirement_authority 退職フラグ
     * @param  int  $restraint_start_time 始業時間
     * @param  int  $restraint_closing_time 終業時間
     * @param  int $restraint_total_time 所定労働時間
     * @param  int  $short_working 時短フラグ
     * @var App\Libraries\php\Domain\Database
     */
    public static function updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority, $restraint_start_time, $restraint_closing_time, $restraint_total_time, $short_working)
    {
        try {
            // 人員を更新
            DataBase::updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority);

            // 所定労働時間を更新
            Database::updateOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time, $short_working);

            //階層に更新
            Database::updateHierarchy($management_emplo_id, $emplo_id);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };
    }

    /**
     * 出勤日数・総勤務時間・残業時間を合計するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $ym 年月
     * @var App\Libraries\php\Domain\Database
     * @var array $total_days 出勤日数
     * @var array $cloumns_name カラム名
     * @var array $total_name 合計値の命名
     * @var array $total_achievement_time 総勤務時間
     * @var array $total_over_time 総残業時間
     * @var array $total_data 出勤日数・総勤務時間・残業時間をまとめたもの
     *
     * @return  array $total_data
     */
    public static function totalTime($emplo_id, $ym)
    {
        // 出勤日数を求める
        $total_days = Database::getTotalDays($emplo_id, $ym);

        // 総勤務時間を求める
        $cloumns_name = "achievement_time";
        $total_name = "total_achievement_time";
        $total_achievement_time = Database::getTotalWorking($cloumns_name, $total_name, $emplo_id, $ym);

        // 残業時間を求める
        $cloumns_name = "over_time";
        $total_name = "total_over_time";
        $total_over_time = Database::getTotalWorking($cloumns_name, $total_name, $emplo_id, $ym);

        // それぞれの結果を配列に格納する
        $total_data = array(
            "total_days" => $total_days[0]->total_days,
            "total_achievement_time" => $total_achievement_time[0]->total_achievement_time,
            "total_over_time" => $total_over_time[0]->total_over_time
        );

        return $total_data;
    }

    /**
     * 指定期間内の出勤日数・総勤務時間・残業時間を合計するクラス
     *
     * @param  int  $emplo_id 社員番号
     * @param  int  $first_day 指定開始日
     * @param  int  $end_day 指定終了日
     * @var App\Libraries\php\Domain\Database
     * @var array $total_days 出勤日数
     * @var array $cloumns_name カラム名
     * @var array $total_name 合計値の命名
     * @var array $total_achievement_time 総勤務時間
     * @var array $total_over_time 総残業時間
     * @var array $total_data 出勤日数・総勤務時間・残業時間をまとめたもの
     *
     * @return  array $total_data
     */
    public static function SearchtotalTime($emplo_id, $first_day, $end_day)
    {
        // 出勤日数を求める
        $total_days = Database::SearchTotalDays($emplo_id, $first_day, $end_day);

        // 総勤務時間を求める
        $cloumns_name = "achievement_time";
        $total_name = "total_achievement_time";
        $total_achievement_time = Database::SearchTotalWorking($cloumns_name, $total_name, $emplo_id, $first_day, $end_day);

        // 残業時間を求める
        $cloumns_name = "over_time";
        $total_name = "total_over_time";
        $total_over_time = Database::SearchTotalWorking($cloumns_name, $total_name, $emplo_id, $first_day, $end_day);

        // それぞれの結果を配列に格納する
        $total_data = array(
            "total_days" => $total_days[0]->total_days,
            "total_achievement_time" => $total_achievement_time[0]->total_achievement_time,
            "total_over_time" => $total_over_time[0]->total_over_time
        );

        return $total_data;
    }

    /**
     * 時短フラグを付与するクラス
     *
     * @var App\Libraries\php\Domain\Database
     * @param  array $working_hours 会社全体の所定労働時間
     * @param  int  $restraint_start_time 始業時間
     * @param  int  $restraint_closing_time 終業時間
     *
     * @return  array $short_working
     */
    public static function working_hours($restraint_start_time, $restraint_closing_time)
    {
        $working_hours = Database::Workinghours();

        // 会社と個人の始業時間と終業時間が合致する場合は、時短フラグは0を付与する
        if (
            strtotime($working_hours[0]->restraint_start_time) == strtotime($restraint_start_time)
            && strtotime($working_hours[0]->restraint_closing_time) == strtotime($restraint_closing_time)
        ) {
            $short_working = "0";
        } else {
            $short_working = "1";
        };

        return $short_working;
    }
}
