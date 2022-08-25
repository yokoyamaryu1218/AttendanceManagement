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
        //@var string hierarchyのカラム列
        $hierarchy_cloumns = 'lower_id, high_id';
        //@var string カラム列のホルダー
        $hierarchy_holder = '?,?';
        // @var array hierarchyの挿入データ
        $hierarchy_insert_data_list = [
            ['1000', '0000'],
            ['1001', '1000'],
            ['1002', '1001'],
            ['1003', '1001'],
            ['1004', '1001'],
            ['1005', '1001'],
            ['1006', '1001'],
            ['1007', '1002'],
            ['1008', '1002'],
            ['1009', '1002'],
            ['1010', '1002'],
            ['1011', '1002'],
            ['1012', '1003'],
            ['1013', '1003'],
            ['1014', '1003'],
            ['1015', '1003'],
            ['1016', '1003'],
            ['1017', '1004'],
            ['1018', '1004'],
            ['1019', '1004'],
            ['1020', '1004'],
        ];

        foreach ($hierarchy_insert_data_list as $insert_data) {
            DB::insert('insert into hierarchy (' . $hierarchy_cloumns . ') VALUES (' . $hierarchy_holder . ')', $insert_data);
        }
    }
}
