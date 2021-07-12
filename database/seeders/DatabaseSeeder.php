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
            UserTypeSeeder::class,
            RowStatusSeeder::class,
            UserTableSeeder::class,
            RoleGroupSeeder::class
        ]);
    }
}
