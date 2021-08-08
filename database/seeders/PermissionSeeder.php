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

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();

        $permissions=array(
            [
                'name' => 'Add',
                'uri'=>'add'
            ],
            [
                'name' => 'Edit',
                'uri'=>'edit'
            ],
            [
                'name' => 'Update',
                'uri'=>'update'
            ],
            [
                'name' => 'Delete',
                'uri'=>'delete'
            ],
            [
                'name' => 'Read',
                'uri'=>'read'
            ],
            [
                'name' => 'Browse',
                'uri'=>'browse'
            ],
            [
                'name' => 'Publish',
                'uri'=>'publish'
            ]
        );

        foreach ($permissions as $permission){
            Permission::create($permission);
        }

        Schema::enableForeignKeyConstraints();
    }
}
