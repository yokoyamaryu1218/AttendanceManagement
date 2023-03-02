<?php

namespace Database\Seeders;

use DateTime;
use DateInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string worksのカラム列
        $works_cloumns = 'emplo_id,date,start_time,closing_time,rest_time,achievement_time,over_time,modifier';
        //@var string カラム列のホルダー
        $works_holder = '?,?,?,?,?,?,?,?';
        // @var array worksの挿入データ
        $startDate = new DateTime('2023-02-01');
        $endDate = new DateTime('2023-04-30');

        // 期間の日数を取得
        $days = $endDate->diff($startDate)->days;

        // 以前に出力した日付とemplo_idのリストを初期化
        $emplo_id_and_date_list = [];

        // ランダムなデータを作成
        $works_insert_data_list = [];

        for ($i = 0; $i < 1000; $i++) {
            // ランダムな日数を生成
            $randomDays = mt_rand(0, $days);

            // 期間の開始日にランダムな日数を加算して、日付を生成
            $date = clone $startDate;
            $date->add(new DateInterval("P{$randomDays}D"));

            // 社員番号を生成
            $emplo_id = strval(mt_rand(1000, 1020));

            // 同じemplo_idで、同じ日付に複数のダミーデータを入れないようにする
            $emplo_id_and_date = $emplo_id . '_' . $date->format('Y/m/d');
            if (in_array($emplo_id_and_date, $emplo_id_and_date_list)) {
                continue;
            } else {
                $emplo_id_and_date_list[] = $emplo_id_and_date;
            }

            // データを作成
            $start_time = '09:00:00';
            $closing_time = '18:00:00';
            $rest_time = '01:00:00';
            $achievement_time = '08:00:00';
            $over_time = '00:00:00';
            $modifier = '管理者';
            $works_insert_data_list[] = [
                $emplo_id,
                $date->format('Y/m/d'),
                $start_time,
                $closing_time,
                $rest_time,
                $achievement_time,
                $over_time,
                $modifier
            ];
        }

        foreach ($works_insert_data_list as $insert_data) {
            DB::insert('insert into works (' . $works_cloumns . ') VALUES (' . $works_holder . ')', $insert_data);
        }
    }
}
