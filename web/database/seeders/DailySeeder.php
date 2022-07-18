<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string dailyのカラム列
        $daily_cloumns = 'id,emplo_id,date,daily,created_at,updated_at';
        //@var string カラム列のホルダー
        $daily_holder = '?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $daily_insert_data_list = [
            ['1', '1001', '2022/07/01', 'ああ', NULL, NULL],
            ['2', '1001', '2022/07/06', 'ああ', NULL, NULL],
            ['3', '1001', '2022/07/11', 'ああ', NULL, NULL],
            ['4', '1001', '2022/07/18', 'ああ', NULL, NULL],
            ['5', '1001', '2022/07/21', 'ああ', NULL, NULL],
            ['6', '1001', '2022/07/20', 'ああ', NULL, NULL],
        ];

        foreach ($daily_insert_data_list as $insert_data) {
            DB::insert('insert into daily (' . $daily_cloumns . ') VALUE (' . $daily_holder . ')', $insert_data);
        }
    }
}
