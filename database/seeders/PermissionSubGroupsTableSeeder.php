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

        DB::table('permission_sub_groups')->insert(array (
            array (
                'id' => 1,
                'key' => 'system_admin_sub_group',
                'permission_group_id' => 1,
                'row_status' => 1,
                'title' => 'সিস্টেম অ্যাডমিন পারমিশন সাব গ্রুপ - ১',
                'title_en' => 'System Admin Permission Sub Group - 1',
                'updated_at' => '2022-01-05 16:36:48',
                'created_at' => '2022-01-05 10:53:45',
            ),
            array (
                'id' => 2,
                'key' => 'system_admin_sub_group_2',
                'permission_group_id' => 1,
                'row_status' => 1,
                'title' => 'সিস্টেম অ্যাডমিন পারমিশন সাব গ্রুপ - ২',
                'title_en' => 'System Admin Permission Sub Group - 2',
                'updated_at' => '2022-01-05 16:37:32',
                'created_at' => '2022-01-05 10:53:45',
            ),
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 3,
                'key' => 'ssp_permission_sub_group_1',
                'permission_group_id' => 2,
                'row_status' => 1,
                'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন সাব গ্রুপ - ১',
                'title_en' => 'SSP Permission Sub Group - 1',
                'updated_at' => '2022-01-10 12:59:08',
            ),
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 4,
                'key' => 'ssp_permission_sub_group_2',
                'permission_group_id' => 2,
                'row_status' => 1,
                'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন সাব গ্রুপ - ২',
                'title_en' => 'SSP Permission Sub Group - 2',
                'updated_at' => '2022-01-05 16:26:37',
            ),
            array (
                'created_at' => '2022-01-12 14:19:59',
                'id' => 5,
                'key' => 'industry_assoc_permission_sub_group_1',
                'permission_group_id' => 3,
                'row_status' => 1,
                'title' => 'শিল্প সংঘ পারমিশন সাব গ্গ্রুপ - ১',
                'title_en' => 'Industry Association Permission Sub Group - 1',
                'updated_at' => '2022-01-12 14:19:59',
            ),
            array (
                'created_at' => '2022-01-12 14:19:59',
                'id' => 6,
                'key' => 'industry_assoc_permission_sub_group_2',
                'permission_group_id' => 3,
                'row_status' => 1,
                'title' => 'শিল্প সংঘ পারমিশন সাব গ্গ্রুপ - ২',
                'title_en' => 'Industry Association Permission Sub Group - 2',
                'updated_at' => '2022-01-12 14:19:59',
            ),
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 7,
                'key' => 'industry_permission_sub_group_1',
                'permission_group_id' => 4,
                'row_status' => 1,
                'title' => 'শিল্প প্রতিষ্ঠান পারমিশন সাব গ্রুপ - ১',
                'title_en' => 'Industry Permission Sub Group - 1',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 8,
                'key' => 'industry_permission_sub_group_2',
                'permission_group_id' => 4,
                'row_status' => 1,
                'title' => 'শিল্প প্রতিষ্ঠান পারমিশন সাব গ্রুপ - ২',
                'title_en' => 'Industry Permission Sub Group - 2',
                'updated_at' => '2022-01-05 10:53:45',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
