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
        $employee_cloumns = 'emplo_id,name,password,email,management_emplo_id,subord_authority,created_at,updated_at';
        //@var string カラム列のホルダー
        $employee_holder = '?,?,?,?,?,?,?,?';
        // @var array employeeの挿入データ
        $employee_insert_data_list = [
            [ '1000', '上司次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', 'test@yahoo.co.jp', '1000', 1, NULL, NULL], //パスワード：password
            [ '1001', '田中太郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', 'yokoyamaryu1218@yahoo.co.jp', '1000', 1, NULL, NULL], //パスワード：password
            [ '1002', '部下一郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', 'test2@yahoo.co.jp', '1001', 0, NULL, NULL], //パスワード：password
            [ '1003', '部下次郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', 'test3@yahoo.co.jp', '1001', 0, NULL, NULL], //パスワード：password
            [ '1004', '部下三郎', '$2y$10$DUOOak6MWz3lJ2.x8A5B2uWTtTFPPDvoenMn2Q3A1i.YHdzbPttx2', 'test4@yahoo.co.jp', '1001', 0, NULL, NULL], //パスワード：password

        ];

        foreach ($employee_insert_data_list as $insert_data) {
            DB::insert('insert into employee (' . $employee_cloumns . ') VALUE (' . $employee_holder . ')', $insert_data);
        }
    }
}
