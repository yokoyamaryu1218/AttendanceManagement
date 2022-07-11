<?php

namespace App\Models;

use Carbon\Carbon;



    //日付に関連するクラス
    class Date {

    /**
     * プロパティ
     * @param   $today 今日の日付
     * 
     */
    private $today;

    /** 
     * 今日の日付を判定するメソッド
     * @param   $today 今日の日付
     * 
     * @return　$today
    */
    public function today() {

     $today = now()->format("Y-m-d H:i:s");

     return $today;
    }

    /** 
     * 3か月後パスワード更新日を判定するメソッド
     * @param   $today 更新予定の日付
     * 
     * @return　$today
    */
    public function password() {

        $dt = now();

        $today = $dt->addMonth(3)->format("Y-m-d H:i:s");
   
        return $today;
       }

    /**
     * 登録日と更新日の日付のフォーマットを変換するメソッド
     * @param array $datas DBデータ 
     * 
     * 
     */
    public function date(&$datas){
        foreach($datas as $data){
            $data->created_at = Carbon::parse($data->created_at)->format('Y/m/d H:i:s');
            $data->updated_at = Carbon::parse($data->updated_at)->format('Y/m/d H:i:s');
        }
    }

    /**
     * 登録日と更新日,運用開始日と運用終了日のフォーマットを変換するメソッド
     * @param array $datas DBデータ 
     * 
     * 
     */
    public function formatDate(&$datas){
        foreach($datas as $data){
            $data->created_at = Carbon::parse($data->created_at)->format('Y/m/d H:i:s');
            $data->updated_at = Carbon::parse($data->updated_at)->format('Y/m/d H:i:s');
            if(isset($data->password_update_day)){
                $data->password_update_day = Carbon::parse($data->password_update_day)->format('Y-m-d');
            }
            $data->operation_start_date = Carbon::parse($data->operation_start_date)->format('Y-m-d');

            if(isset($data->operation_end_date)){
                $data->operation_end_date = Carbon::parse($data->operation_end_date)->format('Y-m-d');
            }
        }
    }

    /**
     * 運用開始日と運用終了日の表記を変換するメソッド
     * @param array $datas DBデータ 
     * 
     * @var   array $date 変換後の日付を格納
     * 
     * @return array $date 
     */
    public function formatOperationDate($datas){

        $date = array();
        foreach($datas as $data){

            $operation_start_date = null;
            $operation_end_date = null;

            $operation_start_date = Carbon::parse($data->operation_start_date)->format('Y-m-d');
            if(isset($data->operation_end_date)){
                $operation_end_date = Carbon::parse($data->operation_end_date)->format('Y-m-d');
            }
            $date = ["operation_start_date" => $operation_start_date,"operation_end_date" => $operation_end_date];

        }
        return $date;

    }
}