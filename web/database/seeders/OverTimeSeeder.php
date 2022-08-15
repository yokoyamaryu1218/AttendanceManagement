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
            ['1000', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1001', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1002',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1003',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1004', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1005', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1006',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1007',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1008', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1009', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1010',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1011',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1012', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1010',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1011',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1012', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1013',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1014',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1015', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1016', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1017',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1018',  '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1019', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
            ['1020', '09:00:00', '18:00:00', '08:00:00', NULL, NULL],
        ];

        foreach ($over_time_insert_data_list as $insert_data) {
            DB::insert('insert into over_time (' . $over_time_cloumns . ') VALUE (' . $over_time_holder . ')', $insert_data);
        }
    }
}
