<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PermissionGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('permission_groups')->truncate();

        DB::table('permission_groups')->insert(array(
            array('id' => '1', 'title_en' => 'System Admin Permission Group', 'title' => 'সিস্টেম অ্যাডমিন পারমিশন গ্রুপ', 'key' => 'system', 'row_status' => '1', 'created_at' => '2022-01-05 22:53:45', 'updated_at' => '2022-02-11 00:34:46'),
            array('id' => '2', 'title_en' => 'Skill/Training Provider Permission Group', 'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন গ্রুপ', 'key' => 'institute', 'row_status' => '1', 'created_at' => '2022-01-05 22:53:45', 'updated_at' => '2022-01-05 22:53:45'),
            array('id' => '3', 'title_en' => 'Industry Association Permission Group', 'title' => 'শিল্প সমিতি পারমিশন গ্রুপ', 'key' => 'industry_association', 'row_status' => '1', 'created_at' => '2022-01-13 02:08:27', 'updated_at' => '2022-02-10 06:09:22'),
            array('id' => '4', 'title_en' => 'Industry Permission Group', 'title' => 'শিল্প প্রতিষ্ঠান পারমিশন গ্রুপ', 'key' => 'organization', 'row_status' => '1', 'created_at' => '2022-01-05 22:53:45', 'updated_at' => '2022-01-05 22:53:45'),
            array('id' => '5', 'title_en' => 'District Commissioner Permission Group', 'title' => 'জেলা প্রশাসক (ডিসি) পারমিশন গ্রুপ', 'key' => 'dc_group', 'row_status' => '1', 'created_at' => '2022-01-25 04:56:18', 'updated_at' => '2022-01-25 04:56:18'),
            array('id' => '6', 'title_en' => 'Registered Training Organization Group', 'title' => 'নিবন্ধিত প্রশিক্ষণ সংস্থা গ্রুপ', 'key' => 'registered_training_organization', 'row_status' => '1', 'created_at' => '2022-03-07 04:58:11', 'updated_at' => '2022-03-07 04:58:11'),
            array('id' => '7', 'title_en' => 'Certificate Authority Permission Group', 'title' => 'সার্টিফিকেট অথরিটি পারমিশন গ্রুপ', 'key' => 'certificate_authority', 'row_status' => '1', 'created_at' => '2022-03-10 05:34:58', 'updated_at' => '2022-03-10 05:34:58'),
            array('id' => '8', 'title_en' => '4IR Permission Group', 'title' => '4 আই আর পারমিশন গ্রুপ', 'key' => '4ir_permission_group', 'row_status' => '1', 'created_at' => '2022-05-20 03:24:03', 'updated_at' => '2022-05-20 03:24:03')
        ));

        Schema::enableForeignKeyConstraints();


    }
}
