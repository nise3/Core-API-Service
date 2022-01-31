<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder
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
                'title_en' => 'System Admin',
                'title' => 'সিস্টেম এডমিন',
                'key' => 'system_admin',
                'permission_group_id' => 1,
                'permission_sub_group_id' => 1,
            ),

            array(
                'title_en' => 'TSP Admin',
                'title' => 'টি এস পি এডমিন',
                'key' => 'tsp_admin',
                'permission_group_id' => 2,
                'permission_sub_group_id' => 2,
            ),

            array(
                'title_en' => 'Industry Admin',
                'title' => 'ইন্ডাস্ট্রি এডমিন',
                'key' => 'industry_admin',
                'permission_group_id' => 3,
                'permission_sub_group_id' => 3,
            ),

            array(
                'title_en' => 'Industry Association Admin',
                'title' => 'ইন্ডাস্ট্রি এসোসিয়েসন এডমিন',
                'key' => 'industry_association_admin',
                'permission_group_id' => 4,
                'permission_sub_group_id' => 4,
            )
        ));

        Schema::enableForeignKeyConstraints();
    }
}
