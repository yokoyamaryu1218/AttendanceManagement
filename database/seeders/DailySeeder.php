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
            ['1001', '2022/07/01', '出勤しました'],
            ['1001', '2022/07/07', '出勤しました'],
            ['1001', '2022/07/08', '出勤しました'],
            ['1001', '2022/07/11', '暑いです'],
            ['1001', '2022/07/14', '出勤しました'],
            ['1001', '2022/07/15', '元気です'],
            ['1001', '2022/08/01', '出勤しました'],
            ['1001', '2022/08/02', '出勤しました'],
            ['1001', '2022/08/03', '出勤しました'],
            ['1001', '2022/08/10', '暑いです'],
            ['1001', '2022/08/11', '元気です'],
        ];

        foreach ($daily_insert_data_list as $insert_data) {
            DB::insert('insert into daily (' . $daily_cloumns . ') VALUES (' . $daily_holder . ')', $insert_data);
        }
    }
}
