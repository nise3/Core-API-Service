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
            RoleTableSeeder::class,
            PermissionSeeder::class,
            PermissionGroupSeeder::class,
            PermissionSubGroupSeeder::class,
            PermissionAssignSeeder::class,
            UserTableSeeder::class,
            DomainTableSeeder::class,
        ]);
    }
}
