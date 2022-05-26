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
            array('domain' => 'nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'NISE' , 'title_prefix_en'=>'NISE' ,'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'DEV' , 'title_prefix_en'=>'DEV' ,  'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'STAGING' , 'title_prefix_en'=>'STAGING' ,  'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'ASM' , 'title_prefix_en'=>'ASM' , 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'youth.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'YOUTH' , 'title_prefix_en'=>'YOUTH' , 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'YOUTH-DEV' , 'title_prefix_en'=>'YOUTH-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'YOUTH-STAGING' , 'title_prefix_en'=>'YOUTH-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'YOUTH-ASM' , 'title_prefix_en'=>'YOUTH-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'dyd.nise.gov.bd', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'DYD' , 'title_prefix_en'=>'DYD','created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd-dev.nise3.xyz', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DYD-DEV' , 'title_prefix_en'=>'DYD-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd-staging.nise3.xyz', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DYD-STAGING' , 'title_prefix_en'=>'DYD-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd.nise.asm', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DYD-ASM' , 'title_prefix_en'=>'DYD-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'sidcht.nise.gov.bd', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT' , 'title_prefix_en'=>'SIDCHT', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht-dev.nise3.xyz', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT-DEV' , 'title_prefix_en'=>'SIDCHT-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht-staging.nise3.xyz', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT-STAGING' , 'title_prefix_en'=>'SIDCHT-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht.nise.asm', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT-ASM' , 'title_prefix_en'=>'SIDCHT-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'mcci.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI' , 'title_prefix_en'=>'MCCI', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI-DEV' , 'title_prefix_en'=>'MCCI-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI-STAGING' , 'title_prefix_en'=>'MCCI-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI-ASM' , 'title_prefix_en'=>'MCCI-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'nascib.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB' , 'title_prefix_en'=>'NASCIB', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB-DEV' , 'title_prefix_en'=>'NASCIB-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB-STAGING' , 'title_prefix_en'=>'NASCIB-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB-ASM' , 'title_prefix_en'=>'NASCIB-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'smef.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF' , 'title_prefix_en'=>'SMEF', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-DEV' , 'title_prefix_en'=>'SMEF-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-STAGING' , 'title_prefix_en'=>'SMEF-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-ASM' , 'title_prefix_en'=>'SMEF-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF' , 'title_prefix_en'=>'SMEF', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'dss.nise.gov.bd', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS' , 'title_prefix_en'=>'DSS', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss-dev.nise3.xyz', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS-DEV' , 'title_prefix_en'=>'DSS-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss-staging.nise3.xyz', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS-STAGING' , 'title_prefix_en'=>'DSS-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss.nise.asm', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS-ASM' , 'title_prefix_en'=>'DSS-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'swapno.nise.gov.bd', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO' , 'title_prefix_en'=>'SWAPNO', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno-dev.nise3.xyz', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-DEV' , 'title_prefix_en'=>'SWAPNO-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno-staging.nise3.xyz', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-STAGING' , 'title_prefix_en'=>'SWAPNO-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno.nise.asm', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-ASM' , 'title_prefix_en'=>'SWAPNO-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'nuprp.nise.gov.bd', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP' , 'title_prefix_en'=>'NUPRP', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp-dev.nise3.xyz', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP-DEV' , 'title_prefix_en'=>'NUPRP-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp-staging.nise3.xyz', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP-STAGING' , 'title_prefix_en'=>'NUPRP-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp.nise.asm', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP-ASM' , 'title_prefix_en'=>'NUPRP-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'futurenation.nise.gov.bd', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION' , 'title_prefix_en'=>'FUTURENATION', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation-dev.nise3.xyz', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION-DEV' , 'title_prefix_en'=>'FUTURENATION-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation-staging.nise3.xyz', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION-STAGING' , 'title_prefix_en'=>'FUTURENATION-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation.nise.asm', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION-ASM' , 'title_prefix_en'=>'FUTURENATION-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'wing.nise.gov.bd', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING' , 'title_prefix_en'=>'WING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing-dev.nise3.xyz', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING-DEV' , 'title_prefix_en'=>'WING-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing-staging.nise3.xyz', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING-STAGING' , 'title_prefix_en'=>'WING-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing.nise.asm', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING-ASM' , 'title_prefix_en'=>'WING-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'ideb.nise.gov.bd', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB' , 'title_prefix_en'=>'IDEB', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb-dev.nise3.xyz', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB-DEV' , 'title_prefix_en'=>'IDEB-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb-staging.nise3.xyz', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB-STAGING' , 'title_prefix_en'=>'IDEB-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb.nise.asm', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB-ASM' , 'title_prefix_en'=>'IDEB-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'rpl.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL' , 'title_prefix_en'=>'RPL', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL-DEV' , 'title_prefix_en'=>'RPL-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL-STAGING' , 'title_prefix_en'=>'RPL-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL-ASM' , 'title_prefix_en'=>'RPL-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'ssp-training.nise3.xyz', 'institute_id' => 47, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SSP-Training' , 'title_prefix_en'=>'SSP-Training', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'bgapmea.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 28,'title_prefix'=>'BGAPMEA' , 'title_prefix_en'=>'BGAPMEA', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bgapmea-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 28,'title_prefix'=>'BGAPMEA-DEV' , 'title_prefix_en'=>'BGAPMEA-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bgapmea-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 28,'title_prefix'=>'BGAPMEA-STAGING' , 'title_prefix_en'=>'BGAPMEA-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bgapmea.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 28,'title_prefix'=>'BGAPMEA-ASM' , 'title_prefix_en'=>'BGAPMEA-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'beioa.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 29,'title_prefix'=>'BEIOA' , 'title_prefix_en'=>'BEIOA', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'beioa-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 29,'title_prefix'=>'BEIOA-DEV' , 'title_prefix_en'=>'BEIOA-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'beioa-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 29,'title_prefix'=>'BEIOA-STAGING' , 'title_prefix_en'=>'BEIOA-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'beioa.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 29,'title_prefix'=>'BEIOA-ASM' , 'title_prefix_en'=>'BEIOA-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'bcmea.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 33,'title_prefix'=>'BCMEA' , 'title_prefix_en'=>'BCMEA', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bcmea-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 33,'title_prefix'=>'BCMEA-DEV' , 'title_prefix_en'=>'BCMEA-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bcmea-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 33,'title_prefix'=>'BCMEA-STAGING' , 'title_prefix_en'=>'BCMEA-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bcmea.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 33,'title_prefix'=>'BCMEA-ASM' , 'title_prefix_en'=>'BCMEA-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'bfea.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 36,'title_prefix'=>'BFEA' , 'title_prefix_en'=>'BFEA', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bfea-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 36,'title_prefix'=>'BFEA-DEV' , 'title_prefix_en'=>'BFEA-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bfea-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 36,'title_prefix'=>'BFEA-STAGING' , 'title_prefix_en'=>'BFEA-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bfea.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 36,'title_prefix'=>'BFEA-ASM' , 'title_prefix_en'=>'BFEA-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'brdb.nise.gov.bd', 'institute_id' => 22, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BRDB' , 'title_prefix_en'=>'BRDB', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'brdb-dev.nise3.xyz', 'institute_id' => 22, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BRDB-DEV' , 'title_prefix_en'=>'BRDB-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'brdb-staging.nise3.xyz', 'institute_id' => 22, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BRDB-STAGING' , 'title_prefix_en'=>'BRDB-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'brdb.nise.asm', 'institute_id' => 22, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BRDB-ASM' , 'title_prefix_en'=>'BRDB-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'afa.nise.gov.bd', 'institute_id' => 49, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'AFA' , 'title_prefix_en'=>'AFA', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'afa-dev.nise3.xyz', 'institute_id' => 49, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'AFA-DEV' , 'title_prefix_en'=>'AFA-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'afa-staging.nise3.xyz', 'institute_id' => 49, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'AFA-STAGING' , 'title_prefix_en'=>'AFA-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'afa.nise.asm', 'institute_id' => 49, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'AFA-ASM' , 'title_prefix_en'=>'AFA-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'bitac.nise.gov.bd', 'institute_id' => 50, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BITAC' , 'title_prefix_en'=>'BITAC', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bitac-dev.nise3.xyz', 'institute_id' => 50, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BITAC-DEV' , 'title_prefix_en'=>'BITAC-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bitac-staging.nise3.xyz', 'institute_id' => 50, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BITAC-STAGING' , 'title_prefix_en'=>'BITAC-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bitac.nise.asm', 'institute_id' => 50, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'BITAC-ASM' , 'title_prefix_en'=>'BITAC-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'bef.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 39,'title_prefix'=>'BEF' , 'title_prefix_en'=>'BEF', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bef-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 39,'title_prefix'=>'BEF-DEV' , 'title_prefix_en'=>'BEF-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bef-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 39,'title_prefix'=>'BEF-STAGING' , 'title_prefix_en'=>'BEF-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'bef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 39,'title_prefix'=>'BEF-ASM' , 'title_prefix_en'=>'BEF-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'agrofoodisc.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 40,'title_prefix'=>'AGROFOODISC' , 'title_prefix_en'=>'AGROFOODISC', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'agrofoodisc-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 40,'title_prefix'=>'AGROFOODISC-DEV' , 'title_prefix_en'=>'AGROFOODISC-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'agrofoodisc-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 40,'title_prefix'=>'AGROFOODISC-STAGING' , 'title_prefix_en'=>'AGROFOODISC-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'agrofoodisc.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 40,'title_prefix'=>'AGROFOODISC-ASM' , 'title_prefix_en'=>'AGROFOODISC-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'tourismisc.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 41,'title_prefix'=>'TOURISMISC' , 'title_prefix_en'=>'TOURISMISC', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'tourismisc-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 41,'title_prefix'=>'TOURISMISC-DEV' , 'title_prefix_en'=>'TOURISMISC-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'tourismisc-staging.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 41,'title_prefix'=>'TOURISMISC-STAGING' , 'title_prefix_en'=>'TOURISMISC-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'tourismisc.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 41,'title_prefix'=>'TOURISMISC-ASM' , 'title_prefix_en'=>'TOURISMISC-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'sit.nise.gov.bd', 'institute_id' => 56, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIT' , 'title_prefix_en'=>'SIT', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sit-dev.nise3.xyz', 'institute_id' => 56, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIT-DEV' , 'title_prefix_en'=>'SIT-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sit-staging.nise3.xyz', 'institute_id' => 56, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIT-STAGING' , 'title_prefix_en'=>'SIT-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sit.nise.asm', 'institute_id' => 56, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIT-ASM' , 'title_prefix_en'=>'SIT-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),

            array('domain' => 'asiattc.nise.gov.bd', 'institute_id' => 57, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'ASIATTC' , 'title_prefix_en'=>'ASIATTC', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'asiattc-dev.nise3.xyz', 'institute_id' => 57, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'ASIATTC-DEV' , 'title_prefix_en'=>'ASIATTC-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'asiattc-staging.nise3.xyz', 'institute_id' => 57, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'ASIATTC-STAGING' , 'title_prefix_en'=>'ASIATTC-STAGING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'asiattc.nise.asm', 'institute_id' => 57, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'ASIATTC-ASM' , 'title_prefix_en'=>'ASIATTC-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
