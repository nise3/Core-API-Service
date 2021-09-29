<?php

namespace Database\Seeders;

use App\Models\RecentActivity;
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
            SliderSeeder::class,
            StaticPageSeeder::class,
            GeoLocationDatabaseSeeder::class,
            RoleTableSeeder::class,
            PermissionSeeder::class,
            PermissionGroupSeeder::class,
            UserTableSeeder::class,
            NoticeOrNewsSeeder::class,
            RecentActivitySeeder::class
        ]);
    }
}
