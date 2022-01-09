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
            0 =>
                array(
                    'id' => 1,
                    'domain' => 'dyd.nise.gov.bd',
                    'institute_id' => 1,
                    'organization_id' => null,
                    'industry_association_id' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array(
                    'id' => 2,
                    'domain' => 'bitac.nise.gov.bd',
                    'institute_id' => 2,
                    'organization_id' => null,
                    'industry_association_id' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
