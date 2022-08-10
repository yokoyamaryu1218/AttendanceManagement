<?php

namespace App\Libraries\php\Domain;

use PDO;
use Illuminate\Support\Facades\DB;

/**
 * データベース動作クラス
 */
class Database
{
    /**
     * 従業員一覧を取得するクラス
     *
     * @param $retirement_authorit　退職フラグ
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getEmployeeAll($retirement_authority)
    {

        $data = DB::select('SELECT emplo_id,name,retirement_authority FROM `employee` WHERE retirement_authority = ?;', [$retirement_authority]);

        return $data;
    }


    /**
     * 選択した従業員詳細の取得
     *
     * @param $emplo_id 社員ID
     * @param $retirement_authority 退職フラグ
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function SelectEmployee($emplo_id, $retirement_authority)
    {

        $data = DB::select('SELECT em1.emplo_id, em1.name, em1.management_emplo_id,
        em1.retirement_authority, em1.subord_authority,em1.created_at,em1.updated_at,em1.hire_date,em1.deleted_at,
        /* ここまでで社員ID、社員名、上司社員ID、退職フラグ、部下参照権限、新規登録日、更新日、入社日（退職日）をemployeeテーブルから取得する */
        em2.name AS high_name,
        /* ここまでで上司名をemployeeテーブルから取得する */
        ot1.restraint_start_time, ot1.restraint_closing_time, ot1.restraint_total_time FROM employee AS em1
        /* 始業時間、終業時間、就業時間をovet_timeテーブルから取得する */
        LEFT JOIN employee AS em2 ON em1.management_emplo_id = em2.emplo_id
        /* emplpyeeテーブルの上司社員IDと別途employeeテーブルの社員IDを結合して取得する */
        LEFT JOIN over_time AS ot1 ON em1.emplo_id = ot1.emplo_id
        /* emplpyeeテーブルの社員IDとover_timeテーブルの社員IDを結合して取得する */
        WHERE em1.emplo_id = ? AND em1.retirement_authority = ? ORDER BY em1.emplo_id', [$emplo_id, $retirement_authority]);
        /* 社員IDと退職フラグを検索条件にして情報を取得し、社員IDを基準に並び替える。 */

        return $data;
    }

    /**
     * 部下参照権限がある社員リストの取得
     *
     * @var   $list 取得データ
     *
     * @return  array $list
     */
    public static function getSubordAuthority()
    {

        $list = DB::select('SELECT name,emplo_id from employee where subord_authority = 1 order by emplo_id');

        return $list;
    }


    /**
     * 最新の社員IDを取得
     *
     * @var   $id ID
     *
     * @return  array $id
     */
    public static function getID()
    {

        $id = DB::select('SELECT emplo_id FROM `employee` ORDER BY emplo_id DESC LIMIT 1');

        return $id;
    }

    /**
     * 社員情報登録
     *
     * @param $emplo_id 社員ID
     * @param $name　社員名
     * @param $password　パスワード
     * @param $management_emplo_id　上司社員ID
     * @param $subord_authority　部下参照権限
     * @param $retirement_authority　退職フラグ
     * @param $$hire_date　入社日
     *
     */
    public static function insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date)
    {
        DB::select('INSERT INTO employee (emplo_id,name,password,management_emplo_id,subord_authority,retirement_authority,hire_date) VALUE (?,?,?,?,?,?,?)', [$emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date]);
    }

    /**
     * 社員情報更新
     *
     * @param $emplo_id 社員ID
     * @param $name　社員名
     * @param $management_emplo_id　上司社員ID
     * @param $subord_authority　部下参照権限
     *
     */
    public static function updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority)
    {
        DB::select(
            'UPDATE employee SET name = ? , management_emplo_id = ?, subord_authority = ? WHERE emplo_id = ?',
            [$name, $management_emplo_id, $subord_authority, $emplo_id]
        );
    }

    /**
     * 階層の登録
     *
     * @param $lower_id 下位ID
     * @param $high_id 上位ID
     *
     */
    public static function insertHierarchy($lower_id, $high_id)
    {
        DB::insert('INSERT INTO hierarchy (lower_id,high_id) VALUE (?,?)', [$lower_id, $high_id]);
    }

    /**
     * 階層の更新
     *
     * @param $lower_id 下位ID
     * @param $high_id 上位ID
     *
     */
    public static function updateHierarchy($high_id, $lower_id)
    {
        DB::insert('UPDATE hierarchy SET high_id = ? WHERE lower_id = ?', [$high_id, $lower_id]);
    }

    /**
     * 退職フラグを付与する
     *
     * @param $retirement_authority 退職フラグ
     * @param $emplo_id 社員ID
     *
     */
    public static function retirementAssignment($retirement_authority, $emplo_id)
    {
        DB::insert('UPDATE employee SET retirement_authority = ? WHERE emplo_id = ?', [$retirement_authority, $emplo_id]);
    }

    /**
     * 退職日を消す
     *
     * @param $emplo_id 社員ID
     *
     */
    public static function Delete_at($emplo_id)
    {
        DB::insert('UPDATE employee SET deleted_at = NULL WHERE emplo_id = ?', [$emplo_id]);
    }

    /**
     * データベースに接続するクラス
     *
     * 選択した社員の勤怠一覧を取得するときと、
     * 対象日のデータがあるかどうかチェックするときに必要な記載
     *
     */
    public static function connect_db()
    {
        $dsn = 'mysql:dbname=attendance_management;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * 選択した社員の勤怠一覧を取得する
     *
     * @param $emplo_id 社員ID
     * @param $ym 年月
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getMonthly($emplo_id, $ym)
    {
        $pdo = self::connect_db();

        $sql = "SELECT wk1.date, wk1.emplo_id, wk1.start_time, wk1.closing_time,
        wk1.rest_time, wk1.achievement_time, wk1.over_time,dl1.daily FROM works AS wk1
        /* ここまでで勤怠日、社員ID、出勤時間、退勤時間、休憩時間、実績時間、残業時間をworksテーブルから取得し、
        対象日の日報をdailyテーブルから取得する */
        LEFT JOIN daily AS dl1 ON wk1.date = dl1.date AND wk1.emplo_id = dl1.emplo_id
        /* dailyテーブルの日付、社員IDと別途worksテーブルの日付、社員IDを結合して取得する */
        WHERE wk1.emplo_id = :emplo_id
        /* 社員IDを検索条件にして情報を取得し、 */
        AND DATE_FORMAT(wk1.date, '%Y-%m') = :date
        /* 日付を選択した年月のものだけ抽出し、 */
        ORDER BY date";
        /* 日付順に並び替える　*/

        // 配列の各データにアクセスしやすいように、行のキーを日付にするため
        // フェッチモードを指定する
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':emplo_id', $emplo_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $ym, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_UNIQUE);

        return $data;
    }

    /**
     * 対象日のデータがあるかどうかチェック
     *
     * @param $emplo_id 社員ID
     * @param $today 今日の日付
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function checkDate($emplo_id, $today)
    {
        $pdo = self::connect_db();

        // 配列の各データにアクセスしやすいように、フェッチモードで行のキーを日付しているため、
        // ここでもフェッチモードでチェックする
        $sql = "SELECT id FROM works WHERE emplo_id = :emplo_id AND date = :date LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':emplo_id', (int)$emplo_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $today, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data;
    }

    /**
     * 今日の日報、出勤時間を取得する
     *
     * @param $cloumns_name カラム名
     * @param $table_name テーブル名
     * @param $emplo_id 社員ID
     * @param $today 今日の日付
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $today)
    {

        $data = DB::select('SELECT ' . $cloumns_name . ' FROM ' . $table_name . ' WHERE emplo_id = ? AND date = ?', [$emplo_id, $today]);

        return $data;
    }

    /**
     * 始業時間と就業時間を取得する
     *
     * @param $cloumns_name カラム名
     * @param $emplo_id 社員ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getRestraintTime($emplo_id)
    {
        $data = DB::select('SELECT restraint_start_time, restraint_total_time FROM over_time WHERE emplo_id =?', [$emplo_id]);

        return $data;
    }

    /**
     * 就業時間の登録
     *
     * @param $emplo_id 社員ID
     * @param $restraint_start_time 始業時間
     * @param $restraint_closing_time　終業時間
     * @param $restraint_total_time 就業時間
     *
     */
    public static function insertOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        DB::select('INSERT INTO over_time (emplo_id,restraint_start_time, restraint_closing_time, restraint_total_time) VALUE (?,?,?,?)', [$emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time]);
    }

    /**
     * 就業時間の更新
     *
     * @param $emplo_id 社員ID
     * @param $restraint_start_time 始業時間
     * @param $restraint_closing_time　終業時間
     * @param $restraint_total_time 就業時間
     *
     */
    public static function updateOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        DB::select(
            'UPDATE over_time SET restraint_start_time = ? ,restraint_closing_time = ?,restraint_total_time = ? WHERE emplo_id = ?',
            [$restraint_start_time, $restraint_closing_time, $restraint_total_time, $emplo_id]
        );
    }

    /**
     * 出勤時間の打刻
     *
     * @param $emplo_id 社員ID
     * @param $today 今日の日付
     * @param $start_time 出勤時間
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertStartTime($emplo_id, $today, $start_time)
    {
        $data =  DB::select('INSERT INTO works (emplo_id,date,start_time) VALUE (?,?,?)', [$emplo_id, $today, $start_time]);

        return $data;
    }

    /**
     * 退勤時間の打刻
     *
     * @param $closing_time 退勤時間
     * @param $rest_time　休憩時間
     * @param $achievement_time　実績時間
     * @param $over_time　残業時間
     * @param $emplo_id　社員ID
     * @param $target_date　対象日
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertEndTime($closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date)
    {
        $data =  DB::select('UPDATE works SET closing_time = ?, rest_time = ?, achievement_time = ?, over_time = ? WHERE emplo_id = ? AND date = ?', [$closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date]);

        return $data;
    }

    /**
     * 打刻時間の新規登録
     *
     * @param $emplo_id　社員ID
     * @param $target_date　対象日
     * @param $start_time 出勤時間
     * @param $closing_time 退勤時間
     * @param $rest_time　休憩時間
     * @param $achievement_time　実績時間
     * @param $over_time　残業時間
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertTime($emplo_id, $target_date, $start_time, $closing_time, $rest_time, $achievement_time, $over_time)
    {
        $data =  DB::select('INSERT INTO works (emplo_id,date,start_time,closing_time,rest_time,achievement_time,over_time) VALUE (?,?,?,?,?,?,?)', [$emplo_id, $target_date, $start_time, $closing_time, $rest_time, $achievement_time, $over_time]);

        return $data;
    }

    /**
     * 打刻時間の更新
     *
     * @param $start_time 出勤時間
     * @param $closing_time 退勤時間
     * @param $rest_time　休憩時間
     * @param $achievement_time　実績時間
     * @param $over_time　残業時間
     * @param $emplo_id　社員ID
     * @param $target_date　対象日
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function updateTime($start_time, $closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date)
    {
        $data =  DB::select('UPDATE works SET start_time = ?,closing_time = ?, rest_time = ?, achievement_time = ?, over_time = ? WHERE emplo_id = ? AND date = ?', [$start_time, $closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date]);

        return $data;
    }

    /**
     * 日報の登録
     *
     * @param $emplo_id　社員ID
     * @param $today 今日の日付
     * @param $daily 日報
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertDaily($emplo_id, $today, $daily)
    {

        $data = DB::select('INSERT INTO daily (emplo_id,date,daily) VALUE (?,?,?)', [$emplo_id, $today, $daily]);

        return $data;
    }

    /**
     * 日報を更新する
     *
     * @param $emplo_id 社員ID
     * @param $today 今日の日付
     * @param $daily 日報
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function updateDaily($emplo_id, $today, $daily)
    {

        $data = DB::select('UPDATE daily SET daily = ? WHERE emplo_id = ? AND date = ?', [$daily, $emplo_id, $today]);

        return $data;
    }

    /**
     * 部下の取得
     *
     * @param $emplo_id　社員ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getSubord($emplo_id)
    {

        $data = DB::select('SELECT em1.emplo_id, em2.emplo_id AS subord_id,
        em2.name AS subord_name FROM employee AS em1
        /* ここまでで勤怠日、ログインしている社員ID、部下の社員IDと部下の名前をemployeeテーブルから取得する */
        LEFT JOIN hierarchy on em1.emplo_id = hierarchy.high_id
        /* hierarchyテーブルの上位IDと、employeeテーブルの社員IDを結合して取得する */
        LEFT JOIN employee AS em2 ON hierarchy.lower_id = em2.emplo_id
        /* 別途hierarchyテーブルの下位IDと、employeeテーブルの社員IDを結合して取得する */
        WHERE em1.emplo_id = ? ORDER BY subord_id', [$emplo_id]);
        /* 社員IDを検索条件にして情報を取得し、部下の社員IDを基準に並び替える。 */

        return $data;
    }

    /**
     * 従業員（部下）のパスワードの更新
     *
     * @param $password パスワード
     * @param $emplo_id　社員ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function subord_updatepassword($password, $emplo_id)
    {

        $data = DB::select('UPDATE employee SET password = ?  WHERE emplo_id = ?', [$password, $emplo_id]);

        return $data;
    }
}
