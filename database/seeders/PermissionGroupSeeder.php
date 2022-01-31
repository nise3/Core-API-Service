<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        DB::table('permission_groups')->insert(array(

            array(
                'title_en' => 'System',
                'title' => 'System',
                'key' => 'system',
            ),

            array(
                'title_en' => 'Tsp',
                'title' => 'Tsp',
                'key' => 'tsp',
            ),

            array(
                'title_en' => 'Industry',
                'title' => 'Industry',
                'key' => 'industry',
            ),

            array(
                'title_en' => 'Industry Association',
                'title' => 'Industry Association',
                'key' => 'industry_association',
            )
        ));

        Schema::enableForeignKeyConstraints();
    }
}
