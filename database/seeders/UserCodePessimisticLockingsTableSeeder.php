<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UserCodePessimisticLockingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('user_code_pessimistic_lockings')->truncate();

        DB::table('user_code_pessimistic_lockings')->insert(array(
            0 =>
                array(
                    'last_incremental_value' => 70,
                ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
