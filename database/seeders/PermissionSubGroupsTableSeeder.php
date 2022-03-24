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

        DB::table('permission_sub_groups')->insert([
            array('id' => '1', 'permission_group_id' => '1', 'title_en' => 'System Admin Permission Sub Group - 1', 'title' => 'সিস্টেম অ্যাডমিন পারমিশন সাব গ্রুপ - ১', 'key' => 'system_admin_sub_group', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-05 22:36:48'),
            array('id' => '2', 'permission_group_id' => '1', 'title_en' => 'System Admin Permission Sub Group - 2', 'title' => 'সিস্টেম অ্যাডমিন পারমিশন সাব গ্রুপ - ২', 'key' => 'system_admin_sub_group_2', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-05 22:37:32'),
            array('id' => '3', 'permission_group_id' => '2', 'title_en' => 'SSP Permission Sub Group - 1', 'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন সাব গ্রুপ - ১', 'key' => 'ssp_permission_sub_group_1', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-10 18:59:08'),
            array('id' => '4', 'permission_group_id' => '2', 'title_en' => 'SSP Permission Sub Group - 2', 'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন সাব গ্রুপ - ২', 'key' => 'ssp_permission_sub_group_2', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-05 22:26:37'),
            array('id' => '5', 'permission_group_id' => '3', 'title_en' => 'Industry Association Permission Sub Group - 1', 'title' => 'শিল্প সমিতি পারমিশন সাব গ্রুপ - ১', 'key' => 'industry_assoc_permission_sub_group_1', 'row_status' => '1', 'created_at' => '2022-01-12 20:19:59', 'updated_at' => '2022-02-10 00:12:26'),
            array('id' => '6', 'permission_group_id' => '3', 'title_en' => 'Industry Association Permission Sub Group - 2', 'title' => 'শিল্প সমিতি পারমিশন সাব গ্রুপ - ২', 'key' => 'industry_assoc_permission_sub_group_2', 'row_status' => '1', 'created_at' => '2022-01-12 20:19:59', 'updated_at' => '2022-02-10 00:12:33'),
            array('id' => '7', 'permission_group_id' => '4', 'title_en' => 'Industry Permission Sub Group - 1', 'title' => 'শিল্প প্রতিষ্ঠান পারমিশন সাব গ্রুপ - ১', 'key' => 'industry_permission_sub_group_1', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-05 16:53:45'),
            array('id' => '8', 'permission_group_id' => '4', 'title_en' => 'Industry Permission Sub Group - 2', 'title' => 'শিল্প প্রতিষ্ঠান পারমিশন সাব গ্রুপ - ২', 'key' => 'industry_permission_sub_group_2', 'row_status' => '1', 'created_at' => '2022-01-05 16:53:45', 'updated_at' => '2022-01-05 16:53:45'),
            array('id' => '9', 'permission_group_id' => '6', 'title_en' => 'Registered Training Organization Sub Group -1', 'title' => 'নিবন্ধিত প্রশিক্ষণ সংস্থা সাব গ্রুপ - ১', 'key' => 'registered_training_organization_sub_group_1', 'row_status' => '1', 'created_at' => '2022-03-06 23:05:57', 'updated_at' => '2022-03-06 23:06:32'),
            array('id' => '10', 'permission_group_id' => '6', 'title_en' => 'Registered Training Organization Sub Group - 2', 'title' => 'নিবন্ধিত প্রশিক্ষণ সংস্থা সাব গ্রুপ - ২', 'key' => 'registered_training_organization_sub_group_2', 'row_status' => '1', 'created_at' => '2022-03-06 23:07:26', 'updated_at' => '2022-03-06 23:07:26'),
            array('id' => '11', 'permission_group_id' => '7', 'title_en' => 'Certificate Authority Permission sub group - 1', 'title' => 'সার্টিফিকেট অথোরিটি পারমিশন সাব গ্রুপ - ১', 'key' => 'certificate_authority_sub_group', 'row_status' => '1', 'created_at' => '2022-03-09 17:58:27', 'updated_at' => '2022-03-09 23:39:12'),
            array('id' => '12', 'permission_group_id' => '2', 'title_en' => 'Skill/Training Provider Permission Sub Group (DSS) -3', 'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন সাব গ্রুপ (ডিএসএস) -৩', 'key' => 'ssp_permission_sub_group_3_dss', 'row_status' => '1', 'created_at' => '2022-03-24 20:55:40', 'updated_at' => '2022-03-24 20:55:40')
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
