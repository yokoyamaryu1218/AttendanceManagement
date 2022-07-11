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
            ['1', '1001', '2022/06/01', 'ああ', NULL, NULL],
            ['2', '1001', '2022/06/02', NULL, NULL, NULL],
            ['3', '1001', '2022/06/03', NULL, NULL, NULL],
            ['4', '1001', '2022/06/04', NULL, NULL, NULL],
            ['5', '1001', '2022/06/05', NULL, NULL, NULL],
            ['6', '1001', '2022/06/06', 'ああ', NULL, NULL],
            ['7', '1001', '2022/06/07', NULL, NULL, NULL],
            ['8', '1001', '2022/06/08', NULL, NULL, NULL],
            ['9', '1001', '2022/06/09', NULL, NULL, NULL],
            ['10', '1001', '2022/06/10', NULL, NULL, NULL],
            ['11', '1001', '2022/06/11', 'ああ', NULL, NULL],
            ['12', '1001', '2022/06/12', NULL, NULL, NULL],
            ['13', '1001', '2022/06/13', NULL, NULL, NULL],
            ['14', '1001', '2022/06/14', NULL, NULL, NULL],
            ['15', '1001', '2022/06/15', NULL, NULL, NULL],
            ['16', '1001', '2022/06/16', 'ああ', NULL, NULL],
            ['17', '1001', '2022/06/17', NULL, NULL, NULL],
            ['18', '1001', '2022/06/18', NULL, NULL, NULL],
            ['19', '1001', '2022/06/19', NULL, NULL, NULL],
            ['20', '1001', '2022/06/20', NULL, NULL, NULL],
            ['21', '1001', '2022/06/21', 'ああ', NULL, NULL],
            ['22', '1001', '2022/06/22', NULL, NULL, NULL],
            ['23', '1001', '2022/06/23', NULL, NULL, NULL],
            ['24', '1001', '2022/06/24', NULL, NULL, NULL],
            ['25', '1001', '2022/06/25', NULL, NULL, NULL],
            ['26', '1001', '2022/06/26', 'ああ', NULL, NULL],
            ['27', '1001', '2022/06/27', NULL, NULL, NULL],
            ['28', '1001', '2022/06/28', NULL, NULL, NULL],
            ['29', '1001', '2022/06/29', NULL, NULL, NULL],
            ['30', '1001', '2022/06/30', NULL, NULL, NULL],

        ];

        foreach ($daily_insert_data_list as $insert_data) {
            DB::insert('insert into daily (' . $daily_cloumns . ') VALUE (' . $daily_holder . ')', $insert_data);
        }
    }
}
