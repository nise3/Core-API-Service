<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();

        DB::table('users')->insert(array(

            array(
                'id' => 1,
                'code' => 'USYS0000001',
                'country' => 'BD',
                'created_at' => '2022-01-09 18:30:56',
                'updated_at' => '2022-01-12 13:01:38',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'email' => 'admin@nise.gov.bd',
                'idp_user_id' => 'ebfc38c1-a990-42ff-a764-8823cd0b618b',
                'industry_association_id' => NULL,
                'organization_id' => NULL,
                'institute_id' => NULL,
                'branch_id' => NULL,
                'training_center_id' => NULL,
                'loc_district_id' => 18,
                'loc_division_id' => 3,
                'loc_upazila_id' => NULL,
                'mobile' => '01710000000',
                'name' => 'নাইস সিস্টেম অ্যাডমিন',
                'name_en' => 'NISE System Admin',
                'password' => null,
                'phone_code' => '880',
                'profile_pic' => 'https://file.nise3.xyz/uploads/hukGd0ZaYGLSfOoftLgVwLbz78Ix6G1641970895.jpg',
                'remember_token' => NULL,
                'role_id' => 1,
                'row_status' => 1,
                'user_type' => 1,
                'username' => 'app_admin',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-08 00:00:00',
                'verification_code_verified_at' => '2022-01-09 18:30:56',
            ),

            array(
                'id' => 2,
                'branch_id' => NULL,
                'code' => 'UINA0000002',
                'country' => 'BD',
                'created_at' => '2022-01-10 13:05:31',
                'updated_at' => '2022-01-10 13:05:31',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'email' => 'tasmidurrahman@gmail.com',
                'idp_user_id' => '3b32042d-d52d-407c-96ab-0380a8f7bfcd',
                'industry_association_id' => 1,
                'institute_id' => NULL,
                'loc_district_id' => 18,
                'loc_division_id' => 3,
                'loc_upazila_id' => NULL,
                'mobile' => '01767111434',
                'name' => 'এমসিসিআই এডমিন',
                'name_en' => 'MCCI Admin',
                'organization_id' => NULL,
                'password' => null,
                'phone_code' => '880',
                'profile_pic' => 'https://file.nise3.xyz/uploads/hukGd0ZaYGLSfOoftLgVwLbz78Ix6G1641970895.jpg',
                'remember_token' => NULL,
                'role_id' => 4,
                'row_status' => 1,
                'training_center_id' => NULL,
                'user_type' => 5,
                'username' => '01788888888',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-08 00:00:00',
                'verification_code_verified_at' => '2022-01-09 18:30:56',
            ),

            array(
                'id' => 3,
                'branch_id' => NULL,
                'code' => 'USSP0000003',
                'country' => 'BD',
                'created_at' => '2022-01-10 13:06:37',
                'updated_at' => '2022-01-11 14:43:03',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'email' => 'rahulbgc21@gmail.com',
                'idp_user_id' => '13772c24-5b67-4996-8a86-284538dc9f77',
                'industry_association_id' => NULL,
                'institute_id' => 1,
                'loc_district_id' => 18,
                'loc_division_id' => 3,
                'loc_upazila_id' => NULL,
                'mobile' => '01674248402',
                'name' => 'যুব উন্নয়ন অধিদপ্তর-এডমিন',
                'name_en' => 'Department of Youth Development-Admin',
                'organization_id' => NULL,
                'password' => NULL,
                'phone_code' => '880',
                'profile_pic' => 'https://file.nise3.xyz/uploads/hukGd0ZaYGLSfOoftLgVwLbz78Ix6G1641970895.jpg',
                'remember_token' => NULL,
                'role_id' => 2,
                'row_status' => 1,
                'training_center_id' => NULL,
                'user_type' => 3,
                'username' => '01812345670',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-08 00:00:00',
                'verification_code_verified_at' => '2022-01-09 18:30:56',
            ),

            array(
                'branch_id' => NULL,
                'code' => 'UINA0000004',
                'country' => 'BD',
                'created_at' => '2022-01-10 13:19:56',
                'updated_at' => '2022-01-10 13:19:56',
                'updated_by' => 1,
                'created_by' => 1,
                'deleted_at' => NULL,
                'email' => 'asmmahmud@gmail.com',
                'id' => 4,
                'idp_user_id' => 'f417b6fd-e713-486b-ad86-99abd379a7da',
                'industry_association_id' => 2,
                'institute_id' => NULL,
                'loc_district_id' => 18,
                'loc_division_id' => 3,
                'loc_upazila_id' => NULL,
                'mobile' => '01790635943',
                'name' => 'নাসিব এডমিন',
                'name_en' => 'NASCIB Admin',
                'organization_id' => NULL,
                'password' => NULL,
                'phone_code' => '880',
                'profile_pic' => 'https://file.nise3.xyz/uploads/hukGd0ZaYGLSfOoftLgVwLbz78Ix6G1641970895.jpg',
                'remember_token' => NULL,
                'role_id' => 5,
                'row_status' => 1,
                'training_center_id' => NULL,
                'user_type' => 5,
                'username' => '01733333333',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-08 00:00:00',
                'verification_code_verified_at' => '2022-01-09 18:30:56',
            ),

            array(
                'branch_id' => NULL,
                'code' => 'USSP0000005',
                'country' => 'BD',
                'created_at' => '2022-01-16 15:54:27',
                'updated_at' => '2022-01-16 15:59:21',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'email' => 'marufmazumder.piistech@gmail.com',
                'id' => 5,
                'idp_user_id' => 'a1842dfc-c3df-4b5a-af53-964173bc0a8e',
                'industry_association_id' => NULL,
                'institute_id' => 2,
                'loc_district_id' => 18,
                'loc_division_id' => 3,
                'loc_upazila_id' => NULL,
                'mobile' => '01813628025',
                'name' => 'এসআইডি - সিএইচটি এডমিন',
                'name_en' => 'SID-CHT Admin',
                'organization_id' => NULL,
                'password' => NULL,
                'phone_code' => '880',
                'profile_pic' => 'https://file.nise3.xyz/uploads/hukGd0ZaYGLSfOoftLgVwLbz78Ix6G1641970895.jpg',
                'remember_token' => NULL,
                'role_id' => 3,
                'row_status' => 1,
                'training_center_id' => NULL,
                'user_type' => 3,
                'username' => '01887263793',
                'verification_code' => '1234',
                'verification_code_sent_at' => '2022-01-08 00:00:00',
                'verification_code_verified_at' => '2022-01-09 18:30:56',
            )
        ));

        Schema::enableForeignKeyConstraints();


    }
}
