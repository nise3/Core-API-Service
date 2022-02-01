<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GeoLocationDatabaseSeeder::class,
            PermissionsTableSeeder::class,
            PermissionGroupsTableSeeder::class,
            PermissionSubGroupsTableSeeder::class,
            PermissionGroupPermissionsTableSeeder::class,
            PermissionSubGroupPermissionsTableSeeder::class,
            RolesTableSeeder::class,
            RolePermissionsTableSeeder::class,
            UsersTableSeeder::class,
        ]);

    }
}
