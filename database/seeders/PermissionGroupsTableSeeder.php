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
            array('id' => '1','title_en' => 'System Admin Permission Group','title' => 'সিস্টেম অ্যাডমিন পারমিশন গ্রুপ','key' => 'system','row_status' => '1','created_at' => '2022-01-05 16:53:45','updated_at' => '2022-01-05 16:53:45'),
            array('id' => '2','title_en' => 'Skill/Training Provider Permission Group','title' => 'দক্ষতা/প্রশিক্ষণ প্রদানকারী পারমিশন গ্রুপ','key' => 'institute','row_status' => '1','created_at' => '2022-01-05 16:53:45','updated_at' => '2022-01-05 16:53:45'),
            array('id' => '3','title_en' => 'Industry Association Permission Group','title' => 'শিল্প সমিতি পারমিশন গ্রুপ','key' => 'industry_association','row_status' => '1','created_at' => '2022-01-12 20:08:27','updated_at' => '2022-02-10 00:09:22'),
            array('id' => '4','title_en' => 'Industry Permission Group','title' => 'শিল্প প্রতিষ্ঠান পারমিশন গ্রুপ','key' => 'organization','row_status' => '1','created_at' => '2022-01-05 16:53:45','updated_at' => '2022-01-05 16:53:45'),
            array('id' => '5','title_en' => 'District Commissioner Permission Group','title' => 'জেলা প্রশাসক (ডিসি) পারমিশন গ্রুপ','key' => 'dc_group','row_status' => '1','created_at' => '2022-01-24 22:56:18','updated_at' => '2022-01-24 22:56:18')
        ));

        Schema::enableForeignKeyConstraints();


    }
}
