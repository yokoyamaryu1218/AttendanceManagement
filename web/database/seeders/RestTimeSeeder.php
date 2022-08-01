<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string employeeのカラム列
        $rest_time_cloumns = 'total_time1,total_time2,rest_time1,rest_time2,rest_time3,created_at,updated_at';
        //@var string カラム列のホルダー
        $rest_time_holder = '?,?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $rest_time_insert_data_list = [
            ['8.0', '6.0', '01:00:00', '00:45:00', '00:00:00', NULL, NULL],
        ];

        foreach ($rest_time_insert_data_list as $insert_data) {
            DB::insert('insert into rest_time (' . $rest_time_cloumns . ') VALUE (' . $rest_time_holder . ')', $insert_data);
        }
    }
}
