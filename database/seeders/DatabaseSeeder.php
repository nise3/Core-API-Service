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
            DomainsTableSeeder::class,
            GeoLocationDatabaseSeeder::class,
            PermissionsTableSeeder::class,
            PermissionGroupsTableSeeder::class,
            PermissionSubGroupsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionGroupPermissionsTableSeeder::class,
            PermissionSubGroupPermissionsTableSeeder::class,
            RolePermissionsTableSeeder::class,
            UserCodePessimisticLockingsTableSeeder::class,
            UsersTableSeeder::class,
        ]);

    }
}
