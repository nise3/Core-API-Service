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

        DB::table('domains')->insert([
            array('domain' => 'nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dev.nise3.xyx', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth-dev.nise3.xyx', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd.nise.gov.bd', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd-dev.nise3.xyz', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd.nise.asm', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht.nise.gov.bd', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht-dev.nise3.xyz', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht.nise.asm', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34')
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
