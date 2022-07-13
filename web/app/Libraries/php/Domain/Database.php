<?php

namespace App\Libraries\php\Domain;

use App\Models\Date;
use Illuminate\Support\Facades\DB;

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

        $data = DB::select('SELECT wk1.id, wk1.emplo_id, wk1.date, wk1.start_time, wk1.end_time,
            wk1.lest_time, wk1.achievement_time, daily.daily,wk1.created_at, wk1.updated_at FROM works AS wk1
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

        $data = DB::select('SELECT wk1.id, wk1.emplo_id, wk1.date, wk1.start_time, wk1.end_time,
            wk1.lest_time, wk1.achievement_time, daily.daily,wk1.created_at, wk1.updated_at FROM works AS wk1
            LEFT JOIN daily ON wk1.date = daily.date
            WHERE wk1.emplo_id = ?
            AND DATE_FORMAT(wk1.date, "%Y-%m") = ? 
            ORDER BY wk1.date', [$emplo_id, $ym]);

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

    public static function subord_authority($emplo_id)
    {

        $data = DB::select('SELECT subord_authority FROM `employee` WHERE emplo_id = ?', [$emplo_id]);

        return $data;
    }
}
