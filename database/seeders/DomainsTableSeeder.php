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
            array('id' => '1', 'domain' => 'nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '2', 'domain' => 'dev.nise3.xyx', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '3', 'domain' => 'nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '4', 'domain' => 'youth.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '5', 'domain' => 'youth-dev.nise3.xyx', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '6', 'domain' => 'youth.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '7', 'domain' => 'dyd.nise.gov.bd', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '8', 'domain' => 'dyd-dev.nise3.xyz', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '9', 'domain' => 'dyd.nise.asm', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '10', 'domain' => 'sidcht.nise.gov.bd', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '11', 'domain' => 'sidcht-dev.nise3.xyz', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '12', 'domain' => 'sidcht.nise.asm', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '13', 'domain' => 'mcci.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '14', 'domain' => 'mcci-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '15', 'domain' => 'mcci.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '16', 'domain' => 'nascib.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '17', 'domain' => 'nascib-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '18', 'domain' => 'nascib.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '19', 'domain' => 'smef.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '20', 'domain' => 'smef-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('id' => '21', 'domain' => 'smef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3, 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34')
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
