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
//        Schema::disableForeignKeyConstraints();
//        DB::table('permissions')->truncate();

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
        $menuOrder=1;
        foreach ($modules as $module) {
            $menuId=DB::table('menus')->insertGetId(
                [
                    'name'=>$module
                ]
            );
            $order=1;
            foreach ($methods as $key => $method) {
                $permissionKey=$module . '-' . $key;
                Permission::create([
                    'name' => $permissionKey,
                    'uri' => self::ROUTE_PREFIX . $module . $method['uri'],
                    'method' => $method['method'],
                    'module' => $module
                ]);
                DB::table('menu_items')->insert([
                    'menu_id'=>$menuId,
                    'title'=>$permissionKey,
                    'title_lang_key'=>'EN',
                    'type'=>'item',
                    'permission_key'=>$permissionKey,
                    'url'=>self::ROUTE_PREFIX . $module . $method['uri'],
                    'order'=>$order++
                ]);
            }
            /** Menu Without Permission */
            DB::table('menu_items')->insert([
                'menu_id'=>$menuId,
                'title'=>$module.'-custom-menuItem',
                'title_lang_key'=>'EN',
                'type'=>'item',
                'permission_key'=>null,
                'url'=>self::ROUTE_PREFIX . $module,
                'order'=>$menuOrder++
            ]);
        }
//        Schema::enableForeignKeyConstraints();
    }
}
