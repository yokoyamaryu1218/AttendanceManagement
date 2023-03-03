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
        // @var array すでに生成されたemplo_idとdateの組み合わせ
        $used_combinations = [];
        for ($i = 0; $i < 1000; $i++) {
            $emplo_id = mt_rand(1000, 1020);
            $date = date('Y/m/d', mt_rand(strtotime('2023/02/01'), strtotime('2023/04/30')));
            $phrases = array('出勤しました', '出勤', '無事終了', '天気は晴れ', '天気は雨', '残業なし');
            $daily = $phrases[array_rand($phrases)];

            $combination = $emplo_id . '|' . $date;
            if (in_array($combination, $used_combinations)) {
                $i--;
                continue;
            }

            DB::insert('insert into daily (emplo_id, date, daily) values (?, ?, ?)', [$emplo_id, $date, $daily]);
            $used_combinations[] = $combination;
        }
    }
}
