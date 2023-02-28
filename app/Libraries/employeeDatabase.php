<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

/**
 * データベース動作クラス(社員の登録に関する処理)
 */
class employeeDatabase
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

        $data = DB::select('SELECT emplo_id,name,retirement_authority FROM employee WHERE retirement_authority = ?', [$retirement_authority]);

        return $data;
    }

    /**
     * 選択した従業員詳細の取得
     *
     * @param $emplo_id 社員番号
     * @param $retirement_authority 退職フラグ
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function SelectEmployee($emplo_id, $retirement_authority)
    {

        $data = DB::select('SELECT em1.emplo_id, em1.name, em1.management_emplo_id,
        em1.retirement_authority, em1.subord_authority,em1.created_at,em1.updated_at,em1.hire_date,em1.retirement_date,
        /* ここまでで社員番号、社員名、上司社員番号、退職フラグ、部下配属権限、新規登録日、更新日、入社日（退職日）をemployeeテーブルから取得する */
        em2.name AS high_name,
        /* ここまでで上司名をemployeeテーブルから取得する */
        ot1.restraint_start_time, ot1.restraint_closing_time, ot1.restraint_total_time FROM employee AS em1
        /* 始業時間、終業時間、所定労働時間をovet_timeテーブルから取得する */
        LEFT JOIN employee AS em2 ON em1.management_emplo_id = em2.emplo_id
        /* emplpyeeテーブルの上司社員番号と別途employeeテーブルの社員番号を結合して取得する */
        LEFT JOIN over_time AS ot1 ON em1.emplo_id = ot1.emplo_id
        /* emplpyeeテーブルの社員番号とover_timeテーブルの社員番号を結合して取得する */
        WHERE em1.emplo_id = ? AND em1.retirement_authority = ? ORDER BY em1.emplo_id', [$emplo_id, $retirement_authority]);
        /* 社員番号と退職フラグを検索条件にして情報を取得し、社員番号を基準に並び替える。 */

        return $data;
    }

    /**
     * 検索した人員情報を取得するメソッド(人名)
     * @param $retirement_authority 退職フラグ
     * @param $search 検索文字
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getSearchName($retirement_authority, $search)
    {
        $data = DB::select('SELECT emplo_id,name,retirement_authority FROM employee WHERE retirement_authority = ?
        and name like ?', [$retirement_authority, '%' . $search . '%']);

        return $data;
    }

    /**
     * 検索した人員情報を取得するメソッド(社員番号)
     * @param $retirement_authority 退職フラグ
     * @param $search 検索文字
     *
     * @var   $data 取得データ
     *
     * @return  array $data
     */
    public static function getSearchID($retirement_authority, $search)
    {

        $data = DB::select('SELECT emplo_id,name,retirement_authority FROM employee WHERE retirement_authority = ?
        and emplo_id like ?', [$retirement_authority, '%' . $search . '%']);

        return $data;
    }

    /**
     * 部下配属権限がある社員リストの取得
     * @param $subord_authority 部下配属権限
     *
     * @var   $list 取得データ
     *
     * @return  array $list
     */
    public static function getSubordAuthority($subord_authority)
    {

        $list = DB::select('SELECT name,emplo_id from employee where subord_authority = ? order by emplo_id', [$subord_authority]);

        return $list;
    }

    /**
     *  部下配属権限がある社員名の取得（Excel出力用）
     *
     * @return  array $list
     */
    public static function getSubordName()
    {

        $list = DB::select('SELECT name from employee where subord_authority = "1" order by emplo_id');

        return $list;
    }

    /**
     *  読み込んだExcelシートの部下配属権限のある社員名を社員IDに置き換える
     *
     * @param $name 社員名
     *
     * @return  array $id
     */
    public static function searchSubordName($name)
    {

        $id = DB::select('SELECT emplo_id from employee where subord_authority = "1" AND name like ? order by emplo_id', ['%' . $name . '%']);

        return $id;
    }

    /**
     * 最新の社員番号を取得
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
     * @param $emplo_id 社員番号
     * @param $name　社員名
     * @param $password　パスワード
     * @param $management_emplo_id　上司社員番号
     * @param $subord_authority　部下配属権限
     * @param $retirement_authority　退職フラグ
     * @param $$hire_date　入社日
     *
     */
    public static function insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date)
    {
        DB::select('INSERT INTO employee (emplo_id,name,password,management_emplo_id,subord_authority,retirement_authority,hire_date) VALUES (?,?,?,?,?,?,?)', [$emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority, $hire_date]);
    }

    /**
     * 社員情報更新
     *
     * @param $emplo_id 社員番号
     * @param $name　社員名
     * @param $management_emplo_id　上司社員番号
     * @param $subord_authority　部下配属権限
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
        DB::insert('INSERT INTO hierarchy (lower_id,high_id) VALUES (?,?)', [$lower_id, $high_id]);
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
     * @param $retirement_date 退職日
     * @param $deleted_at 退職処理日
     * @param $emplo_id 社員番号
     *
     */
    public static function retirementAssignment($retirement_authority, $retirement_date, $deleted_at, $emplo_id)
    {
        DB::insert('UPDATE employee SET retirement_authority = ? , retirement_date = ?, deleted_at = ? WHERE emplo_id = ?', [$retirement_authority, $retirement_date, $deleted_at, $emplo_id]);
    }

    /**
     * 従業員リストの取得（Excel出力用）
     *
     * @param $retirement_authority 退職フラグ
     *
     * @return  array $data
     */
    public static function getEmployeeList($retirement_authority)
    {
        if ($retirement_authority == 1) {
            $data = DB::select('SELECT em1.emplo_id, em1.name, em1.subord_authority,em2.name AS high_name,ot1.restraint_start_time, ot1.restraint_closing_time, ot1.short_working, em1.hire_date,em1.retirement_date
            FROM employee AS em1
            LEFT JOIN employee AS em2 ON em1.management_emplo_id = em2.emplo_id
            LEFT JOIN over_time AS ot1 ON em1.emplo_id = ot1.emplo_id
            ORDER BY em1.emplo_id');
        } else {
            $data = DB::select('SELECT em1.emplo_id, em1.name, em1.subord_authority,em2.name AS high_name,ot1.restraint_start_time, ot1.restraint_closing_time, ot1.short_working, em1.hire_date,em1.retirement_date
            FROM employee AS em1
            LEFT JOIN employee AS em2 ON em1.management_emplo_id = em2.emplo_id
            LEFT JOIN over_time AS ot1 ON em1.emplo_id = ot1.emplo_id
            WHERE em1.retirement_authority = 0
            ORDER BY em1.emplo_id');
        }

        return $data;
    }

    /**
     * 読み込んだExcelシートの社員名がDB上にあるか検索をする（完全一致）
     *
     * @param $search
     *
     * @return  array $data
     */
    public static function getName($search)
    {
        $data = DB::select('SELECT emplo_id,name,retirement_authority FROM employee WHERE name = ?', [$search]);

        return $data;
    }
}
