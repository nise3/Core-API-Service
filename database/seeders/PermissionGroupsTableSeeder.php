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
                'created_at' => '2022-01-05 10:53:45',
                'id' => 1,
                'key' => 'system',
                'row_status' => 1,
                'title' => 'System',
                'title_en' => 'System',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            1 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 2,
                'key' => 'organization',
                'row_status' => 1,
                'title' => 'Organization',
                'title_en' => 'Organization',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            2 => 
            array (
                'created_at' => '2022-01-05 10:53:45',
                'id' => 3,
                'key' => 'institute',
                'row_status' => 1,
                'title' => 'Institute',
                'title_en' => 'Institute',
                'updated_at' => '2022-01-05 10:53:45',
            ),
            3 => 
            array (
                'created_at' => '2022-01-12 14:08:27',
                'id' => 4,
                'key' => 'industry_association',
                'row_status' => 1,
                'title' => 'Industry Association',
                'title_en' => 'Industry Association',
                'updated_at' => '2022-01-12 14:08:27',
            ),
            4 => 
            array (
                'created_at' => '2022-01-24 16:56:18',
                'id' => 5,
                'key' => 'issue',
                'row_status' => 1,
                'title' => 'Issue',
                'title_en' => 'Issue',
                'updated_at' => '2022-01-24 16:56:18',
            ),
        ));

        Schema::enableForeignKeyConstraints();

        
    }
}