<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DomainsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('domains')->truncate();

        \DB::table('domains')->insert(array (
            0 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'nise.gov.bd',
                'id' => 1,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            1 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'dev.nise3.xyx',
                'id' => 2,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            2 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'nise.asm',
                'id' => 3,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            3 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'youth.nise.gov.bd',
                'id' => 4,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            4 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'youth-dev.nise3.xyx',
                'id' => 5,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            5 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'youth.nise.asm',
                'id' => 6,
                'industry_association_id' => NULL,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            6 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'dyd.nise.gov.bd',
                'id' => 7,
                'industry_association_id' => NULL,
                'institute_id' => 26,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            7 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'dyd-dev.nise3.xyz',
                'id' => 8,
                'industry_association_id' => NULL,
                'institute_id' => 26,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            8 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'dyd.nise.asm',
                'id' => 9,
                'industry_association_id' => NULL,
                'institute_id' => 26,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            9 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'sidcht.nise.gov.bd',
                'id' => 10,
                'industry_association_id' => NULL,
                'institute_id' => 27,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            10 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'sidcht-dev.nise3.xyz',
                'id' => 11,
                'industry_association_id' => NULL,
                'institute_id' => 27,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            11 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'sidcht.nise.asm',
                'id' => 12,
                'industry_association_id' => NULL,
                'institute_id' => 27,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            12 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'mcci.nise.gov.bd',
                'id' => 13,
                'industry_association_id' => 1,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            13 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'mcci-dev.nise3.xyz',
                'id' => 14,
                'industry_association_id' => 1,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            14 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'mcci.nise.asm',
                'id' => 15,
                'industry_association_id' => 1,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            15 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'nascib.nise.gov.bd',
                'id' => 16,
                'industry_association_id' => 2,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            16 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'nascib-dev.nise3.xyz',
                'id' => 17,
                'industry_association_id' => 2,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            17 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'nascib.nise.asm',
                'id' => 18,
                'industry_association_id' => 2,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            18 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'smef.nise.gov.bd',
                'id' => 19,
                'industry_association_id' => 3,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            19 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'smef-dev.nise3.xyz',
                'id' => 20,
                'industry_association_id' => 3,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
            20 =>
            array (
                'created_at' => '2022-01-31 18:40:31',
                'domain' => 'smef.nise.asm',
                'id' => 21,
                'industry_association_id' => 3,
                'institute_id' => NULL,
                'organization_id' => NULL,
                'updated_at' => '2022-01-31 18:40:31',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
