<?php

namespace Database\Seeders;

use App\Models\BaseModel;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use App\Models\User;
use App\Services\Common\CodeGenerateService;
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
        $code = CodeGenerateService::getUserCode(BaseModel::SYSTEM_USER);

        $data = [
            "code" => $code,
            'name_en' => 'System Admin',
            'name' => 'System Admin',
            'email' => 'support@nise.gov.bd',
            'mobile' => '01790000000',
            'username' => 'app_admin',
            'role_id' => 1,
            'idp_user_id' => 'f54c7ff7-c7ee-42d1-8fa9-45b6069805c3',
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
