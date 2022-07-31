<?php

namespace App\Libraries\php\Domain;

use PDO;
use App\Models\Date;
use Illuminate\Support\Facades\DB;
use App\Libraries\php\Domain\ConnectDB;

/**
 * データベース動作クラス
 */

class Database
{
    /**
     *
     * @param $client 顧客ID
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getAll($emplo_id)
    {

        $data = DB::select('SELECT wk1.id, wk1.emplo_id, wk1.date, wk1.start_time, wk1.closing_time,
            wk1.rest_time, wk1.achievement_time, daily.daily,wk1.created_at, wk1.updated_at FROM works AS wk1
            LEFT JOIN daily ON wk1.date = daily.date
            WHERE wk1.emplo_id = ? ORDER BY daily.date', [$emplo_id]);

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
    public static function getMonthly($emplo_id, $ym)
    {

        $connect = new ConnectDB();
        $pdo = $connect->connect_db();

        $sql = "SELECT wk1.date, wk1.emplo_id, wk1.start_time, wk1.closing_time,
        wk1.rest_time, wk1.achievement_time, wk1.over_time,dl1.daily FROM works AS wk1
        LEFT JOIN daily AS dl1 ON wk1.date = dl1.date AND wk1.emplo_id = dl1.emplo_id
        WHERE wk1.emplo_id = :emplo_id
        AND DATE_FORMAT(wk1.date, '%Y-%m') = :date
        ORDER BY date";

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
    public static function getRestraintStartTime($emplo_id)
    {

        $data = DB::select('SELECT restraint_start_time FROM over_time WHERE emplo_id =?', [$emplo_id]);

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
    public static function getRestraintTotalTime($emplo_id)
    {

        $data = DB::select('SELECT restraint_total_time FROM over_time WHERE emplo_id =?', [$emplo_id]);

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
    public static function checkDate($emplo_id, $target_date)
    {
        $connect = new ConnectDB();
        $pdo = $connect->connect_db();

        $sql = "SELECT id FROM works WHERE emplo_id = :emplo_id AND date = :date LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':emplo_id', (int)$emplo_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $target_date, PDO::PARAM_STR);
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
    public static function insertStartTime($emplo_id, $target_date, $start_time)
    {
        $data =  DB::select('INSERT INTO works (emplo_id,date,start_time) VALUE (?,?,?)', [$emplo_id, $target_date, $start_time]);

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
