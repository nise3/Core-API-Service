<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::flush();
        $this->call([
            DomainsTableSeeder::class,
            GeoLocationDatabaseSeeder::class,
            PermissionsTableSeeder::class,
            PermissionGroupsTableSeeder::class,
            PermissionSubGroupsTableSeeder::class,
            PermissionGroupPermissionsTableSeeder::class,
            PermissionSubGroupPermissionsTableSeeder::class,
            RolesTableSeeder::class,
            RolePermissionsTableSeeder::class,
            UserCodePessimisticLockingsTableSeeder::class,
            UsersTableSeeder::class,
        ]);

    }
}
