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
        //@var string worksのカラム列
        $works_cloumns = 'emplo_id,date,start_time,closing_time,rest_time,achievement_time,over_time';
        //@var string カラム列のホルダー
        $works_holder = '?,?,?,?,?,?,?';
        // @var array worksの挿入データ
        $works_insert_data_list = [
            ['1001', '2022/07/01', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/04', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/05', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/06', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/07', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/08', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/11', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1001', '2022/07/12', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/13', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/14', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/07/15', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/01', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/02', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/03', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/04', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/05', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/08', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1001', '2022/08/09', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1001', '2022/08/10', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1001', '2022/08/11', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/01', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/04', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/05', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/06', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/07', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/08', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/11', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1002', '2022/07/12', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/13', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/14', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/07/15', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/01', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/02', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/03', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/04', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/05', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/08', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1002', '2022/08/09', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
            ['1002', '2022/08/10', '09:00:00', '18:30:00', '1:00:00', '8:00:00', '0:30:00'],
            ['1002', '2022/08/11', '09:00:00', '18:00:00', '1:00:00', '8:00:00', '0:00:00'],
        ];

        foreach ($works_insert_data_list as $insert_data) {
            DB::insert('insert into works (' . $works_cloumns . ') VALUES (' . $works_holder . ')', $insert_data);
        }
    }
}
