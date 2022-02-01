<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PermissionSubGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('permission_sub_groups')->truncate();

        \DB::table('permission_sub_groups')->insert(array (
            0 =>
            array (
                'created_at' => NULL,
                'id' => 1,
                'key' => 'system',
                'permission_group_id' => 1,
                'row_status' => 1,
                'title' => 'System Sub Group',
                'title_en' => 'System Sub Group',
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'created_at' => NULL,
                'id' => 2,
                'key' => 'tsp',
                'permission_group_id' => 2,
                'row_status' => 1,
                'title' => 'Tsp Sub Group',
                'title_en' => 'Tsp Sub Group',
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'created_at' => NULL,
                'id' => 3,
                'key' => 'industry',
                'permission_group_id' => 3,
                'row_status' => 1,
                'title' => 'Industry Sub Group',
                'title_en' => 'Industry Sub Group',
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'created_at' => NULL,
                'id' => 4,
                'key' => 'industry_association',
                'permission_group_id' => 4,
                'row_status' => 1,
                'title' => 'Industry Association Sub Group',
                'title_en' => 'Industry Association Sub Group',
                'updated_at' => NULL,
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
