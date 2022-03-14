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
            PermissionRelatedSeeder::class,
            UserCodePessimisticLockingsTableSeeder::class,
//          RolesTableSeeder::class,
//          RolePermissionsTableSeeder::class,
//          UsersTableSeeder::class,
        ]);

    }
}
