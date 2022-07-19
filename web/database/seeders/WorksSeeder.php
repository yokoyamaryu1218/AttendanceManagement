<?php

namespace Database\Seeders;

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
        //@var string employeeのカラム列
        $works_cloumns = 'emplo_id,date,start_time,end_time,lest_time,achievement_time,created_at,updated_at';
        //@var string カラム列のホルダー
        $works_holder = '?,?,?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $works_insert_data_list = [
            ['1001', '2022/07/01', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/02', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/03', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/06', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/07', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/08',  '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/09',    '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/13', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/14', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
            ['1001',    '2022/07/18', '10:00:00', '16:00:00', '1:00:00', '5:00:00', NULL, NULL],
        ];

        foreach ($works_insert_data_list as $insert_data) {
            DB::insert('insert into works (' . $works_cloumns . ') VALUE (' . $works_holder . ')', $insert_data);
        }
    }
}