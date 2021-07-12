<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();

        DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'role_id' => 1,
                    'name_en' => 'Admin',
                    'name_bn' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'row_status' => 1
                ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
