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

        DB::table('roles')->insert([
            array('id' => '1', 'key' => 'system_admin_role', 'title_en' => 'NISE System-Admin Role', 'title' => 'নাইস সিস্টেম-এডমিন রোল', 'permission_group_id' => '1', 'permission_sub_group_id' => '1', 'organization_id' => NULL, 'industry_association_id' => NULL, 'institute_id' => NULL, 'description' => NULL, 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-01-12 19:01:38', 'deleted_at' => NULL),
            array('id' => '2', 'key' => 'dyd_admin_role', 'title_en' => 'Department of Youth Development-Admin Role', 'title' => 'যুব উন্নয়ন অধিদপ্তর-এডমিন রোল', 'permission_group_id' => '2', 'permission_sub_group_id' => '3', 'organization_id' => NULL, 'industry_association_id' => NULL, 'institute_id' => '1', 'description' => 'Department of Youth Development-Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:05:36', 'deleted_at' => NULL),
            array('id' => '3', 'key' => 'sidcht_admin_role', 'title_en' => 'SID-CHT Admin Role', 'title' => 'এসআইডি - সিএইচটি এডমিন রোল', 'permission_group_id' => '2', 'permission_sub_group_id' => '3', 'organization_id' => NULL, 'industry_association_id' => NULL, 'institute_id' => '2', 'description' => 'SID-CHT Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:05:50', 'deleted_at' => NULL),
            array('id' => '4', 'key' => 'bitac_admin_role', 'title_en' => 'BITAC Admin Role', 'title' => 'বিটাক এডমিন রোল', 'permission_group_id' => '2', 'permission_sub_group_id' => '3', 'organization_id' => NULL, 'industry_association_id' => NULL, 'institute_id' => '3', 'description' => 'BITAC Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:05:50', 'deleted_at' => NULL),
            array('id' => '5', 'key' => 'mcci_admin_role', 'title_en' => 'MCCI Admin Role', 'title' => 'এমসিসিআই এডমিন রোল', 'permission_group_id' => '3', 'permission_sub_group_id' => '5', 'organization_id' => NULL, 'industry_association_id' => '1', 'institute_id' => NULL, 'description' => 'MCCI Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:06:21', 'deleted_at' => NULL),
            array('id' => '6', 'key' => 'nascib_admin_role', 'title_en' => 'NASCIB Admin Role', 'title' => 'নাসিব এডমিন রোল', 'permission_group_id' => '3', 'permission_sub_group_id' => '5', 'organization_id' => NULL, 'industry_association_id' => '2', 'institute_id' => NULL, 'description' => 'NASCIB Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:06:38', 'deleted_at' => NULL),
            array('id' => '7', 'key' => 'smef_admin_role', 'title_en' => 'SMEF Admin Role', 'title' => 'এসএমইএফ এডমিন রোল', 'permission_group_id' => '3', 'permission_sub_group_id' => '5', 'organization_id' => NULL, 'industry_association_id' => '3', 'institute_id' => NULL, 'description' => 'SMEF Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:06:38', 'deleted_at' => NULL),
            array('id' => '8', 'key' => 'dss_admin_role', 'title_en' => 'DSS Admin Role', 'title' => 'সমাজসেবা এডমিন রোল', 'permission_group_id' => '2', 'permission_sub_group_id' => '3', 'organization_id' => NULL, 'industry_association_id' => NULL, 'institute_id' => '4', 'description' => 'BITAC Admin Role', 'row_status' => '1', 'created_at' => '2022-01-10 00:30:56', 'updated_at' => '2022-02-09 21:05:50', 'deleted_at' => NULL),
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
