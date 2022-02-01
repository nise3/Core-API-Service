<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'branch_id' => NULL,
                'code' => 'USYS0000001',
                'country' => 'BD',
                'created_at' => '2022-01-31 18:40:31',
                'created_by' => NULL,
                'deleted_at' => NULL,
                'email' => 'support@nise.gov.bd',
                'id' => 1,
                'idp_user_id' => 'f54c7ff7-c7ee-42d1-8fa9-45b6069805c3',
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'loc_district_id' => NULL,
                'loc_division_id' => NULL,
                'loc_upazila_id' => NULL,
                'mobile' => '01790000000',
                'name' => 'System Admin',
                'name_en' => 'System Admin',
                'organization_id' => NULL,
                'password' => '$2y$10$kodEIlRAM.Ao4pK8wi6FoOmSMyUHGqn6gNxElKMM4yyRL5.EM8K2G',
                'phone_code' => '880',
                'profile_pic' => NULL,
                'remember_token' => NULL,
                'role_id' => 1,
                'row_status' => 1,
                'training_center_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
                'updated_by' => NULL,
                'user_type' => 1,
                'username' => 'app_admin',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-30 00:00:00',
                'verification_code_verified_at' => '2022-01-31 18:40:30',
            ),
        ));


    }
}
