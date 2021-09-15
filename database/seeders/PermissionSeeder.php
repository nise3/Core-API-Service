<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const ROUTE_PREFIX = 'api/v1/';

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();

        $methods = [
            'get_all' => [
                'method' => 1,
                'uri' => ''
            ],
            'read' => [
                'method' => 1,
                'uri' => '/{id}'
            ],
            'add' => [
                'method' => 2,
                'uri' => ''
            ],
            'update' => [
                'method' => 3,
                'uri' => '/{id}'
            ],
            'delete' => [
                'method' => 5,
                'uri' => '/{id}'
            ]
        ];

        $modules = [
            'divisions',
            'districts',
            'upazilas',
            'users',
            'roles',
            'permissions',
            'permission-groups',
            'permission-sub-groups'
        ];

        foreach ($modules as $module) {
            foreach ($methods as $key => $method) {
                Permission::create([
                    'name' => $module . '-' . $key,
                    'uri' => self::ROUTE_PREFIX . $module . $method['uri'],
                    'method' => $method['method'],
                    'module' => $module
                ]);
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
