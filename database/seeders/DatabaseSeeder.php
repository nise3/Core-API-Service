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

            RolesTableSeeder::class,
            UsersTableSeeder::class,
            PermissionGroupPermissionsTableSeeder::class,
            PermissionSubGroupPermissionsTableSeeder::class,
            RolePermissionsTableSeeder::class,
        ]);

        $this->call(UsersTableSeeder::class);
    }
}
