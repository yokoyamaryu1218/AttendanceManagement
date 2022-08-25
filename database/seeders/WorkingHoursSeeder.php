<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class WorkingHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string dailyのカラム列
        $working_cloumns = 'restraint_start_time,restraint_closing_time';
        //@var string カラム列のホルダー
        $working_holder = '?,?';
        // @var array employeeの挿入データ
        $working_insert_data_list = [
            ['10:00:00','18:00:00'],
        ];

        foreach ($working_insert_data_list as $insert_data) {
            DB::insert('insert into working_hours (' . $working_cloumns . ') VALUE (' . $working_holder . ')', $insert_data);
        }
    }
}
