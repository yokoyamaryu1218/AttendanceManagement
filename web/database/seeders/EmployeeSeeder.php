<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string employeeのカラム列
        $employee_cloumns = 'emplo_id,name,password,management_emplo_id,subord_authority,retirement_authority,created_at,updated_at,hire_date,retirement_date';
        //@var string カラム列のホルダー
        $employee_holder = '?,?,?,?,?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $employee_insert_data_list = [
            ['1000', '上司次郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1001', '田中太郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1000', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1002', '山田一郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1003', '田中次郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1004', '部下三郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1005', '下山五郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1006', '田中田中', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password123
            ['1007', '大谷平治郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1002', 0, 0, NULL, NULL, '2012/04/01', NULL], //パスワード：password123
            ['1008', '佐藤菊五郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1002', 0, 1, NULL, NULL, '2012/04/01', '2022/04/01'], //パスワード：password123
            ['1009', '安本信孝', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1002', 0, 0, NULL, NULL, '2012/10/01', NULL], //パスワード：password123
            ['1010', '鈴木平八郎', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1002', 0, 0, NULL, NULL, '2012/10/01', NULL], //パスワード：password123
            ['1011', '名前一二三四', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1002', 0, 0, NULL, NULL, '2012/10/01', NULL], //パスワード：password123
            ['1012', '森口博美', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1003', 0, 0, NULL, NULL, '2012/10/01', NULL], //パスワード：password123
            ['1013', '安田あさみ', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1003', 0, 0, NULL, NULL, '2015/04/01', NULL], //パスワード：password123
            ['1014', 'JohnKeben', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1003', 0, 0, NULL, NULL, '2015/04/01', NULL], //パスワード：password123
            ['1015', 'KenTanaka', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1003', 0, 0, NULL, NULL, '2015/04/01', NULL], //パスワード：password123
            ['1016', 'SonMasanobu', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1003', 0, 0, NULL, NULL, '2018/04/01', NULL], //パスワード：password123
            ['1017', 'KeinKosugi', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1004', 0, 0, NULL, NULL, '2018/04/01', NULL], //パスワード：password123
            ['1018', 'MituyaYuji', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1004', 0, 0, NULL, NULL, '2018/04/01', NULL], //パスワード：password123
            ['1019', '横山隆', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1004', 0, 1, NULL, NULL, '2018/08/01', '2022/08/01'], //パスワード：password123
            ['1020', '斉藤隆', '$2y$10$Tk7u9UGA7Jzi8t8B7uUcIeEggY3Qr2d3ct7ba3eMmDt1gluYhZ6la',  '1004', 0, 0, NULL, NULL, '2018/08/01', NULL], //パスワード：password123
        ];

        foreach ($employee_insert_data_list as $insert_data) {
            DB::insert('insert into employee (' . $employee_cloumns . ') VALUE (' . $employee_holder . ')', $insert_data);
        }
    }
}
