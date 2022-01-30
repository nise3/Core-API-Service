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
                'id' => 1,
                'domain' => 'nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'id' => 2,
                'domain' => 'dev.nise3.xyx',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

            array(
                'id' => 3,
                'domain' => 'nise.asm',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

            array(
                'id' => 2,
                'domain' => 'youth.nise.gov.bd',
                'institute_id' => null,
                'organization_id' => null,
                'industry_association_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 =>
                array(
                    'id' => 3,
                    'domain' => 'dyd.nise.gov.bd',
                    'institute_id' => 26,
                    'organization_id' => null,
                    'industry_association_id' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array(
                    'id' => 4,
                    'domain' => 'bitac.nise.gov.bd',
                    'institute_id' => 27,
                    'organization_id' => null,
                    'industry_association_id' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array(
                    'id' => 5,
                    'domain' => 'mcci.nise.gov.bd',
                    'institute_id' => null,
                    'organization_id' => null,
                    'industry_association_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                )

        ));
    }
}
