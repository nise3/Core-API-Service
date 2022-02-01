<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->truncate();

        DB::table('roles')->insert(array(

            array(
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 1,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'key' => 'system_admin_role',
                'organization_id' => NULL,
                'permission_group_id' => 1,
                'permission_sub_group_id' => 1,
                'row_status' => 1,
                'title' => 'নাইস সিস্টেম-এডমিন রোল',
                'title_en' => 'NISE System-Admin Role',
            ),
            array(
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 2,
                'industry_association_id' => NULL,
                'institute_id' => 1,
                'key' => 'dyd_admin_role',
                'organization_id' => NULL,
                'permission_group_id' => 2,
                'permission_sub_group_id' => 2,
                'row_status' => 1,
                'title' => 'যুব উন্নয়ন অধিদপ্তর-এডমিন রোল',
                'title_en' => 'Department of Youth Development-Admin Role',
            ),
            array(
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 3,
                'industry_association_id' => NULL,
                'institute_id' => 2,
                'key' => 'sidcht_admin_role',
                'organization_id' => NULL,
                'permission_group_id' => 2,
                'permission_sub_group_id' => 2,
                'row_status' => 1,
                'title' => 'এসআইডি - সিএইচটি এডমিন রোল',
                'title_en' => 'SID-CHT Admin Role',
            ),
            array(
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 4,
                'industry_association_id' => 1,
                'institute_id' => NULL,
                'key' => 'mcci_admin_role',
                'organization_id' => NULL,
                'permission_group_id' => 4,
                'permission_sub_group_id' => 4,
                'row_status' => 1,
                'title' => 'এমসিসিআই এডমিন রোল',
                'title_en' => 'MCCI Admin Role',
            ),
            array(
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 5,
                'industry_association_id' => 2,
                'institute_id' => NULL,
                'key' => 'nascib_admin_role',
                'organization_id' => NULL,
                'permission_group_id' => 4,
                'permission_sub_group_id' => 4,
                'row_status' => 1,
                'title' => 'নাসিব এডমিন রোল',
                'title_en' => 'NASCIB Admin Role',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
