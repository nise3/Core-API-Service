<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('permission_groups')->truncate();
        DB::table('permission_sub_groups')->truncate();

        PermissionGroup::factory()
            ->count(7)
            ->has(PermissionSubGroup::factory()->count(3))
            ->create();

        Schema::enableForeignKeyConstraints();

    }
}
