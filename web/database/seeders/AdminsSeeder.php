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
        $admins_cloumns = 'emplo_id,name,password,admin_authority,created_at,updated_at';
        //@var string カラム列のホルダー
        $admins_holder = '?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $admins_insert_data_list = [
            ['1000', '管理用アカウント1', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 1, NULL, NULL], //パスワード：password123
            ['1001', '管理用アカウント2', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 1, NULL, NULL], //パスワード：password123
            ['1002', '管理用アカウント3', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0, NULL, NULL], //パスワード：password123
            ['1003', '管理用アカウント4', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0, NULL, NULL], //パスワード：password123
            ['1004', '管理用アカウント5', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la', 0, NULL, NULL], //パスワード：password123
        ];

        foreach ($admins_insert_data_list as $insert_data) {
            DB::insert('insert into admins (' . $admins_cloumns . ') VALUE (' . $admins_holder . ')', $insert_data);
        }
    }
}
