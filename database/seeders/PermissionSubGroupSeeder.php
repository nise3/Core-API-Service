<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionSubGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('permission_sub_groups')->truncate();

        DB::table('permission_sub_groups')->insert(array(

            array(
                'title_en' => 'System Sub Group',
                'title' => 'System Sub Group',
                'key' => 'system',
                'permission_group_id' => 1,
            ),
            array(
                'title_en' => 'Tsp Sub Group',
                'title' => 'Tsp Sub Group',
                'key' => 'tsp',
                'permission_group_id' => 2,
            ),
            array(
                'title_en' => 'Industry Sub Group',
                'title' => 'Industry Sub Group',
                'key' => 'industry',
                'permission_group_id' => 3,
            ),
            array(
                'title_en' => 'Industry Association Sub Group',
                'title' => 'Industry Association Sub Group',
                'key' => 'industry_association',
                'permission_group_id' => 4,
            ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
