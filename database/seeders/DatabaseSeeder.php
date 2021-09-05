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
            GalleryCategorySeeder::class,
            VideoCategorySeeder::class,
            GeoLocationDatabaseSeeder::class,
            RoleTableSeeder::class,
            PermissionSeeder::class,
            PermissionGroupSeeder::class,
            UserTableSeeder::class,
        ]);
    }
}
