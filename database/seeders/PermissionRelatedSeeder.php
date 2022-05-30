<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionRelatedSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionGroupsTableSeeder::class);
        $this->call(PermissionSubGroupsTableSeeder::class);
        $this->call(PermissionGroupPermissionsTableSeeder::class);
        $this->call(PermissionSubGroupPermissionsTableSeeder::class);
    }
}
