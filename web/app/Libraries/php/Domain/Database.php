<?php

namespace App\Libraries\php\Domain;

use PDO;
use App\Models\Date;
use Illuminate\Support\Facades\DB;

/**
 * データベース動作クラス
 */

class Database
{
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
     * 従業員のデータを取得するクラス
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
        em1.retirement_authority, em1.subord_authority,em1.created_at,em1.updated_at,em1.deleted_at,
        /* ここまでで社員ID、社員名、上司社員ID、退職フラグ、部下参照権限、新規登録日、更新日、退職日をemployeeテーブルから取得する */
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
     * 部下参照権限が1の社員IDと社員名の取得
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
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getDaily($emplo_id, $today)
    {

        $data = DB::select('SELECT daily FROM daily WHERE emplo_id = ? AND date = ?', [$emplo_id, $today]);

        return $data;
    }

    /**
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getStartTime($emplo_id, $target_date)
    {

        $data = DB::select('SELECT start_time FROM works WHERE emplo_id = ? AND date = ?', [$emplo_id, $target_date]);

        return $data;
    }

    /**
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getOverTime($cloumns_name, $emplo_id)
    {
        $data = DB::select('SELECT ' . $cloumns_name . ' FROM over_time WHERE emplo_id =?', [$emplo_id]);

        return $data;
    }

    /**
     *
     * @param $client 顧客ID
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
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function checkDate($emplo_id, $today)
    {
        $pdo = self::connect_db();

        $sql = "SELECT id FROM works WHERE emplo_id = :emplo_id AND date = :date LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':emplo_id', (int)$emplo_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $today, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data;
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
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
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function CheckEndTime($target_date)
    {
        $check = DB::select('SELECT id FROM works WHERE closing_time IS NULL AND date = ?', [$target_date]);

        return $check;
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority)
    {
        DB::select('INSERT INTO employee (emplo_id,name,password,management_emplo_id,subord_authority,retirement_authority) VALUE (?,?,?,?,?,?)', [$emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority]);
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority)
    {
        DB::select(
            'UPDATE employee SET name = ? , management_emplo_id = ?, subord_authority = ? WHERE emplo_id = ?',
            [$name, $management_emplo_id, $subord_authority, $emplo_id]
        );
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        DB::select('INSERT INTO over_time (emplo_id,restraint_start_time, restraint_closing_time, restraint_total_time) VALUE (?,?,?,?)', [$emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time]);
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function updateOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time)
    {
        DB::select(
            'UPDATE over_time SET restraint_start_time = ? ,restraint_closing_time = ?,restraint_total_time = ? WHERE emplo_id = ?',
            [$restraint_start_time, $restraint_closing_time, $restraint_total_time, $emplo_id]
        );
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function insertHierarchy($lower_id, $high_id)
    {
        DB::insert('INSERT INTO hierarchy (lower_id,high_id) VALUE (?,?)', [$lower_id, $high_id]);
    }

    /**
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function updateHierarchy($high_id, $lower_id)
    {
        DB::insert('UPDATE hierarchy SET high_id = ? WHERE lower_id = ?', [$high_id, $lower_id]);
    }

    /**
     * 退職フラグを付与する
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function retirementAssignment($retirement_authority, $emplo_id)
    {
        DB::insert('UPDATE employee SET retirement_authority = ? WHERE emplo_id = ?', [$retirement_authority, $emplo_id]);
    }

    /**
     * 退職日を消す
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function Delete_at($emplo_id)
    {
        DB::insert('UPDATE employee SET deleted_at = NULL WHERE emplo_id = ?', [$emplo_id]);
    }


    /**
     * @param $client 顧客ID
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
     * @param $client 顧客ID
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
     * 対象日のデータがあるかどうかチェック
     * @param $client 顧客ID
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
     *
     * @param $client 顧客ID
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
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getSubord($emplo_id)
    {

        $data = DB::select('SELECT em1.emplo_id, em1.name,
        em2.emplo_id AS subord_id, em2.name AS subord_name FROM employee AS em1
        LEFT JOIN hierarchy on em1.emplo_id = hierarchy.high_id
        LEFT JOIN employee AS em2 on hierarchy.lower_id = em2.emplo_id
        where em1.emplo_id = ? order by em1.emplo_id', [$emplo_id]);

        return $data;
    }

    /**
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function authoritycheck($cloumns_name, $emplo_id)
    {
        $data = DB::select('SELECT ' . $cloumns_name . ' FROM `employee` WHERE emplo_id = ?', [$emplo_id]);

        return $data;
    }

    /**
     *
     * @param $client 顧客ID
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
