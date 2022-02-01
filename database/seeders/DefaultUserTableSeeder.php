<?php

namespace Database\Seeders;

use App\Models\BaseModel;
use App\Models\Role;
use App\Models\User;
use App\Services\Common\CodeGenerateService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DefaultUserTableSeeder extends Seeder
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

        $code = CodeGenerateService::getUserCode(BaseModel::SYSTEM_USER);
        $role = Role::where('key', 'system_admin')->firstOrFail();

        $data = [
            'code' => $code,
            'name_en' => 'System Admin',
            'name' => 'System Admin',
            'email' => 'support@nise.gov.bd',
            'mobile' => '01790000000',
            'username' => 'app_admin',
            'role_id' => $role->id,
            'idp_user_id' => 'f54c7ff7-c7ee-42d1-8fa9-45b6069805c3',
            'user_type' => BaseModel::SYSTEM_USER,
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
