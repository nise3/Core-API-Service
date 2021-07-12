<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('role_groups')->truncate();

        DB::table('role_groups')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Super User',
                    'key' => 'super_user',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'System User',
                    'key' => 'system_user'
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Institute User',
                    'key' => 'institute_user',
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Organization User',
                    'key' => 'organization_user',
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'DC',
                    'key' => 'dc',
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
