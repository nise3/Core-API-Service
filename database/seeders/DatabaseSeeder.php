<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
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
            UserTableSeeder::class,
            PermissionSeeder::class,
            PermissionGroupSeeder::class,
            PermissionSubGroupSeeder::class
        ]);
    }
}
