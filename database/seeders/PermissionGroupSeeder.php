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
                    'title_en' =>  'System',
                    'title' =>  'System',
                    'key' => 'system',
                ],
                [
                    'title_en' =>  'Organization',
                    'title' =>  'Organization',
                    'key' => 'organization',
                ],
                [
                    'title_en' =>  'Institute',
                    'title' =>  'Institute',
                    'key' => 'institute',
                ]
            ))
            ->has(PermissionSubGroup::factory()->count(2))
            ->create();

//        Schema::enableForeignKeyConstraints();

    }
}
