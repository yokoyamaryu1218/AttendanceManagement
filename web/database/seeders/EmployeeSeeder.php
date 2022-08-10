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
        $employee_cloumns = 'emplo_id,name,password,management_emplo_id,subord_authority,retirement_authority,created_at,updated_at,hire_date,deleted_at';
        //@var string カラム列のホルダー
        $employee_holder = '?,?,?,?,?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $employee_insert_data_list = [
            ['1000', '上司次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '0000', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1001', '田中太郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1000', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1002', '部下一郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1003', '部下次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1004', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1005', '上司次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1006', '田中太郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1007', '部下一郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1008', '部下次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1009', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1010', '上司次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1011', '田中太郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1012', '部下一郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1013', '部下次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1014', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1015', '上司次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1016', '田中太郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 1, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1017', '部下一郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1018', '部下次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1019', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 0, NULL, NULL, '2010/10/01', NULL], //パスワード：password
            ['1020', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2',  '1001', 0, 1, NULL, NULL, '2010/10/01', NULL], //パスワード：password
        ];

        foreach ($employee_insert_data_list as $insert_data) {
            DB::insert('insert into employee (' . $employee_cloumns . ') VALUE (' . $employee_holder . ')', $insert_data);
        }
    }
}
