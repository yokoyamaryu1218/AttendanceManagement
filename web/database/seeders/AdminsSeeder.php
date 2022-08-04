<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string employeeのカラム列
        $admins_cloumns = 'emplo_id,name,password,created_at,updated_at';
        //@var string カラム列のホルダー
        $admins_holder = '?,?,?,?,?';
        // @var array employeeの挿入データ
        $admins_insert_data_list = [
            ['admin', '管理用アカウント', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', NULL, NULL], //パスワード：password
        ];

        foreach ($admins_insert_data_list as $insert_data) {
            DB::insert('insert into admins (' . $admins_cloumns . ') VALUE (' . $admins_holder . ')', $insert_data);
        }
    }
}
