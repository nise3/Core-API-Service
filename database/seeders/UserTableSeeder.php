<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
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
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();

        $permissions = Permission::orderBy('id', 'ASC')->pluck('id')->toArray();

        $permissionGroup = PermissionGroup::find(1);
        $permissionGroup->permissions()->sync($permissions);

        $permissionSubGroup = PermissionSubGroup::find(1);
        $permissionSubGroup->permissions()->sync($permissions);

        $role = Role::find(1);
        $role->permissions()->sync($permissions);

        $data = [
            'name_en' => 'Super Admin',
            'name' => 'Super Admin',
            'email' => 'super@gmail.com',
            'username' => 'super_admin',
            'role_id' => 1,
            'idp_user_id' => '89d24658-74db-45b0-babc-de5b9baaee1e',
            'user_type' => 1,
            'verification_code' => '1234',
            'verification_code_sent_at' => Carbon::yesterday(),
            'verification_code_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
        ];

        $user = new User();
        $user->fill($data);
        $user->save();

        Schema::enableForeignKeyConstraints();
    }
}
