<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
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
    }
}
