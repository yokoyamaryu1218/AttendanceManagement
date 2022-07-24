<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OverTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string employeeのカラム列
        $over_time_cloumns = 'emplo_id,restraint_start_time,restraint_closing_time,restraint_total_time,created_at,updated_at';
        //@var string カラム列のホルダー
        $over_time_holder = '?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $over_time_insert_data_list = [
            ['1000', '10:00:00', '15:00:00', '05:00:00', NULL, NULL],
            ['1001', '06:00:00', '12:00:00', '05:00:00', NULL, NULL],
            ['1002',  '10:00:00', '15:00:00', '05:00:00', NULL, NULL],
            ['1003',  '10:00:00', '15:00:00', '05:00:00', NULL, NULL],
            ['1004', '10:00:00', '15:00:00', '05:00:00', NULL, NULL],

        ];

        foreach ($over_time_insert_data_list as $insert_data) {
            DB::insert('insert into over_time (' . $over_time_cloumns . ') VALUE (' . $over_time_holder . ')', $insert_data);
        }
    }
}
