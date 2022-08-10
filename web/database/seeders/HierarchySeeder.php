<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //@var string employeeのカラム列
        $hierarchy_cloumns = 'lower_id, high_id ,created_at,updated_at';
        //@var string カラム列のホルダー
        $hierarchy_holder = '?,?,?,?';
        // @var array employeeの挿入データ
        $hierarchy_insert_data_list = [
            ['1000', '0000', NULL, NULL],
            ['1001', '1000', NULL, NULL],
            ['1002', '1001', NULL, NULL],
            ['1003', '1001', NULL, NULL],
            ['1004', '1001', NULL, NULL],
            ['1005', '1001', NULL, NULL],
            ['1006', '1001', NULL, NULL],
            ['1007', '1001', NULL, NULL],
            ['1008', '1001', NULL, NULL],
            ['1009', '1001', NULL, NULL],
            ['1010', '1001', NULL, NULL],
            ['1011', '1001', NULL, NULL],
            ['1012', '1001', NULL, NULL],
            ['1013', '1001', NULL, NULL],
            ['1014', '1001', NULL, NULL],
            ['1015', '1001', NULL, NULL],
            ['1016', '1001', NULL, NULL],
            ['1017', '1001', NULL, NULL],
            ['1018', '1001', NULL, NULL],
            ['1019', '1001', NULL, NULL],
            ['1020', '1001', NULL, NULL],
        ];

        foreach ($hierarchy_insert_data_list as $insert_data) {
            DB::insert('insert into hierarchy (' . $hierarchy_cloumns . ') VALUE (' . $hierarchy_holder . ')', $insert_data);
        }
    }
}
