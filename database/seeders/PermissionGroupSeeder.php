<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
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
//        Schema::disableForeignKeyConstraints();
//
//        DB::table('permission_groups')->truncate();
//        DB::table('permission_sub_groups')->truncate();

        PermissionGroup::factory()
            ->count(3)
            ->state(new Sequence(
                [
                    'title_en' =>  'System User',
                    'title_bn' =>  'System User',
                    'key' => 'system_user',
                ],
                [
                    'title_en' =>  'Organization User',
                    'title_bn' =>  'Organization User',
                    'key' => 'organization_user',
                ],
                [
                    'title_en' =>  'Institute User',
                    'title_bn' =>  'Institute User',
                    'key' => 'institute_user',
                ]
            ))
            ->has(PermissionSubGroup::factory()->count(2))
            ->create();

//        Schema::enableForeignKeyConstraints();

    }
}
