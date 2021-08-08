<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use Illuminate\Database\Seeder;
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
        PermissionSubGroup::factory()->count(10)->create();
    }
}
