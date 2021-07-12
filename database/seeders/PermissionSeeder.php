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
                'key'=>'add'
            ],
            [
                'name' => 'Edit',
                'key'=>'edit'
            ],
            [
                'name' => 'Update',
                'key'=>'update'
            ],
            [
                'name' => 'Delete',
                'key'=>'delete'
            ],
            [
                'name' => 'Read',
                'key'=>'read'
            ],
            [
                'name' => 'Browse',
                'key'=>'browse'
            ],
            [
                'name' => 'Publish',
                'key'=>'publish'
            ]
        );

        foreach ($permissions as $permission){
            Permission::create($permission);
        }
    }
}
