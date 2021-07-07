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
            0 =>
                array(
                    'id' => 1,
                    'title_en' => 'Super Admin',
                    'title_bn' => 'সুপার এডমিন',
                    'code' => 'super_admin',
                    'is_deletable' => '0'
                ),
            1 =>
                array(
                    'id' => 2,
                    'title_en' => 'System Admin',
                    'title_bn' => 'সিস্টেম এডমিন',
                    'code' => 'system_admin',
                    'is_deletable' => '0'
                ),
            2 =>
                array(
                    'id' => 3,
                    'title_en' => 'Institute Admin',
                    'title_bn' => 'ইনস্টিটিউট এডমিন',
                    'code' => 'institute_admin',
                    'is_deletable' => '0'
                ),
            3 =>
                array(
                    'id' => 4,
                    'title_en' => 'Organization Admin',
                    'title_bn' => 'অর্গানাইজেশন এডমিন',
                    'code' => 'organization_admin',
                    'is_deletable' => '0'
                ),
            4 =>
                array(
                    'id' => 5,
                    'title_en' => 'DC',
                    'title_bn' => 'ডিসি',
                    'code' => 'dc',
                    'is_deletable' => '0'
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
