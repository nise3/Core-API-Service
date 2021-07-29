<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('user_types')->truncate();

        DB::table('user_types')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'title' => 'Super User',
                    'code' => '1',
                    'row_status' => 1,
                    'role_group_id' => '1'
                ),
            1 =>
                array(
                    'id' => 2,
                    'title' => 'System User',
                    'code' => '2',
                    'row_status' => 1,
                    'role_group_id' => '2'
                ),
            2 =>
                array(
                    'id' => 3,
                    'title' => 'Institute User',
                    'code' => '3',
                    'row_status' => 1,
                    'role_group_id' => '3'
                ),
            3 =>
                array(
                    'id' => 4,
                    'title' => 'Organization User',
                    'code' => '4',
                    'row_status' => 1,
                    'role_group_id' => '4'
                ),
            4 =>
                array(
                    'id' => 5,
                    'title' => 'DC',
                    'code' => '5',
                    'row_status' => 1,
                    'role_group_id' => '5'
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
