<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->truncate();

        DB::table('domains')->insert(array(

            array(
                'domain' => 'nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'dev.nise3.xyx',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

            array(
                'domain' => 'nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

            array(
                'domain' => 'youth.nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'youth-dev.nise3.xyx',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'youth.nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'dyd.nise.gov.bd',
                'institute_id' => 26,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'dyd-dev.nise3.xyz',
                'institute_id' => 26,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'dyd.nise.asm',
                'institute_id' => 26,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'sidcht.nise.gov.bd',
                'institute_id' => 27,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'sidcht-dev.nise3.xyz',
                'institute_id' => 27,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'sidcht.nise.asm',
                'institute_id' => 27,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'mcci.nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'mcci-dev.nise3.xyz',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'mcci.nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'nascib.nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'nascib-dev.nise3.xyz',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'nascib.nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            )
        ,
            array(
                'domain' => 'smef.nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'smef-dev.nise3.xyz',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'domain' => 'smef.nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            )
        ));
    }
}
