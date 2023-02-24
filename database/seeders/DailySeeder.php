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
        $daily_cloumns = 'emplo_id,date,daily';
        //@var string カラム列のホルダー
        $daily_holder = '?,?,?';
        // @var array dailyの挿入データ
        $daily_insert_data_list = [
            ['1001', '2023/01/01', '出勤しました'],
            ['1001', '2023/01/07', '出勤しました'],
            ['1001', '2023/01/08', '出勤しました'],
            ['1001', '2023/01/11', '暑いです'],
            ['1001', '2023/01/14', '出勤しました'],
            ['1001', '2023/01/15', '元気です'],
            ['1001', '2023/02/01', '出勤しました'],
            ['1001', '2023/02/02', '出勤しました'],
            ['1001', '2023/02/03', '出勤しました'],
            ['1001', '2023/02/10', '暑いです'],
            ['1001', '2023/02/11', '元気です'],
        ];

        foreach ($daily_insert_data_list as $insert_data) {
            DB::insert('insert into daily (' . $daily_cloumns . ') VALUES (' . $daily_holder . ')', $insert_data);
        }
    }
}
