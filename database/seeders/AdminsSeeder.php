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
        //@var string adminsのカラム列
        $admins_cloumns = 'emplo_id,name,password,admin_authority';
        //@var string カラム列のホルダー
        $admins_holder = '?,?,?,?';
        // @var array adminsの挿入データ
        $admins_insert_data_list = [
            ['k1000', '管理用アカウント1', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 1], //パスワード：password123
            ['k1001', '管理用アカウント2', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 1], //パスワード：password123
            ['k1002', '管理用アカウント3', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0], //パスワード：password123
            ['k1003', '管理用アカウント4', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0], //パスワード：password123
            ['k1004', '管理用アカウント5', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0], //パスワード：password123
        ];

        foreach ($admins_insert_data_list as $insert_data) {
            DB::insert('insert into admins (' . $admins_cloumns . ') VALUES (' . $admins_holder . ')', $insert_data);
        }
    }
}
