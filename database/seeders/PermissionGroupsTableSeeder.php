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
            array(
                'created_at' => '2022-01-05 10:53:45',
                'id' => 1,
                'key' => 'system',
                'row_status' => 1,
                'title' => 'সিস্টেম অ্যাডমিন পারমিশন গ্রুপ',
                'title_en' => 'System Admin Permission Group',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            array(
                'created_at' => '2022-01-05 10:53:45',
                'id' => 2,
                'key' => 'organization',
                'row_status' => 1,
                'title' => 'শিল্প প্রতিষ্ঠান পারমিশন গ্রুপ',
                'title_en' => 'Industry Permission Group',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            array(
                'created_at' => '2022-01-05 10:53:45',
                'id' => 3,
                'key' => 'institute',
                'row_status' => 1,
                'title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন গ্রুপ',
                'title_en' => 'Skill/Training Provider Permission Group',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            array(
                'created_at' => '2022-01-12 14:08:27',
                'id' => 4,
                'key' => 'industry_association',
                'row_status' => 1,
                'title' => 'শিল্প সংঘ পারমিশন গ্রুপ',
                'title_en' => 'Industry Association Permission Group',
                'updated_at' => '2022-01-12 14:08:27',
            ),
            array(
                'created_at' => '2022-01-24 16:56:18',
                'id' => 5,
                'key' => 'dc_group',
                'row_status' => 1,
                'title' => 'জেলা প্রশাসক (ডিসি) পারমিশন গ্রুপ',
                'title_en' => 'District Commissioner Permission Group',
                'updated_at' => '2022-01-24 16:56:18',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
