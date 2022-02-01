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
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 1,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'key' => 'system_admin',
                'organization_id' => NULL,
                'permission_group_id' => 1,
                'permission_sub_group_id' => 1,
                'row_status' => 1,
                'title' => 'সিস্টেম এডমিন',
                'title_en' => 'System Admin',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 2,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'key' => 'tsp_admin',
                'organization_id' => NULL,
                'permission_group_id' => 2,
                'permission_sub_group_id' => 2,
                'row_status' => 1,
                'title' => 'টি এস পি এডমিন',
                'title_en' => 'TSP Admin',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 3,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'key' => 'industry_admin',
                'organization_id' => NULL,
                'permission_group_id' => 3,
                'permission_sub_group_id' => 3,
                'row_status' => 1,
                'title' => 'ইন্ডাস্ট্রি এডমিন',
                'title_en' => 'Industry Admin',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'deleted_at' => NULL,
                'description' => NULL,
                'id' => 4,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'key' => 'industry_association_admin',
                'organization_id' => NULL,
                'permission_group_id' => 4,
                'permission_sub_group_id' => 4,
                'row_status' => 1,
                'title' => 'ইন্ডাস্ট্রি এসোসিয়েসন এডমিন',
                'title_en' => 'Industry Association Admin',
                'updated_at' => NULL,
            ),
        ));

        Schema::enableForeignKeyConstraints();

        
    }
}