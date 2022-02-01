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
                'created_at' => '2022-01-05 10:53:45',
                'id' => 1,
                'key' => 'system_admin_sub_group',
                'permission_group_id' => 1,
                'row_status' => 1,
                'title' => 'System Admin SUB GROUP',
                'title_en' => 'System Admin SUB GROUP',
                'updated_at' => '2022-01-05 16:36:48',
            ),
            1 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 2,
                'key' => 'system_admin_sub_group_2',
                'permission_group_id' => 1,
                'row_status' => 1,
                'title' => 'System Admin SUB GROUP 2',
                'title_en' => 'System Admin SUB GROUP 2',
                'updated_at' => '2022-01-05 16:37:32',
            ),
            2 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 3,
                'key' => 'radiologic_technician',
                'permission_group_id' => 2,
                'row_status' => 1,
                'title' => 'Radiologic Technician Bn',
                'title_en' => 'Radiologic Technician En',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            3 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 5,
                'key' => 'institute_admin_sub_group',
                'permission_group_id' => 3,
                'row_status' => 1,
                'title' => 'Institute Admin Sub Group',
                'title_en' => 'Institute Admin Sub Group',
                'updated_at' => '2022-01-10 12:59:08',
            ),
            4 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 6,
                'key' => 'aviation_inspector',
                'permission_group_id' => 3,
                'row_status' => 1,
                'title' => 'Bitac DYD',
                'title_en' => 'Bitac DYD',
                'updated_at' => '2022-01-05 16:26:37',
            ),
            5 => 
            array (
                'created_at' => '2022-01-12 14:19:59',
                'id' => 7,
                'key' => 'industry_assoc_sub_group',
                'permission_group_id' => 4,
                'row_status' => 1,
                'title' => 'Industry Assoc Sub Group',
                'title_en' => 'Industry Assoc Sub Group',
                'updated_at' => '2022-01-12 14:19:59',
            ),
            6 => 
            array (
                'created_at' => '2022-01-24 17:04:40',
                'id' => 8,
                'key' => 'issue_sub_group',
                'permission_group_id' => 5,
                'row_status' => 1,
                'title' => 'Issue sub group',
                'title_en' => 'Issue sub group',
                'updated_at' => '2022-01-24 17:04:40',
            ),
        ));

        Schema::enableForeignKeyConstraints();

        
    }
}