<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Schema::disableForeignKeyConstraints();
//        DB::table('users')->truncate();

//        $roles = Role::all();
//
//        foreach ($roles as $role) {
//            User::factory()->count(3)->for($role)->create();
//        }
//        Schema::enableForeignKeyConstraints();


        $role = Role::find(1);
        $permissions = Permission::orderBy('id', 'ASC')->pluck('id')->toArray();
        $role->permissions()->sync($permissions);

        $data = [
            'name_en' => 'Super Admin',
            'name_bn' => 'Super Admin',
            'email' => 'super@gmail.com',
            'username' => 'super_admin',
            'role_id' => 1,
            'user_type' => 1,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
        ];

        $user = new User();
        $user->fill($data);
        $user->save();

    }
}
