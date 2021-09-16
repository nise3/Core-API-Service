<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
//        Schema::disableForeignKeyConstraints();
//        DB::table('users')->truncate();

        $roles = Role::all();

        foreach ($roles as $role) {
            User::factory()->count(3)->for($role)->create();
        }
//        Schema::enableForeignKeyConstraints();
    }
}
