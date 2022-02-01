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

        \DB::table('permission_groups')->insert(array (
            0 =>
            array (
                'created_at' => NULL,
                'id' => 1,
                'key' => 'system',
                'row_status' => 1,
                'title' => 'System',
                'title_en' => 'System',
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'created_at' => NULL,
                'id' => 2,
                'key' => 'tsp',
                'row_status' => 1,
                'title' => 'Tsp',
                'title_en' => 'Tsp',
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'created_at' => NULL,
                'id' => 3,
                'key' => 'industry',
                'row_status' => 1,
                'title' => 'Industry',
                'title_en' => 'Industry',
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'created_at' => NULL,
                'id' => 4,
                'key' => 'industry_association',
                'row_status' => 1,
                'title' => 'Industry Association',
                'title_en' => 'Industry Association',
                'updated_at' => NULL,
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
