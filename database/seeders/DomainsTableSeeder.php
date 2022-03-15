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
            array('domain' => 'nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'ASM' , 'title_prefix_en'=>'ASM' , 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'YOUTH' , 'title_prefix_en'=>'YOUTH' , 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'YOUTH-DEV' , 'title_prefix_en'=>'YOUTH-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'youth.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'YOUTH-ASM' , 'title_prefix_en'=>'YOUTH-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd.nise.gov.bd', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL, 'title_prefix'=>'DYD' , 'title_prefix_en'=>'DYD','created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd-dev.nise3.xyz', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DYD-DEV' , 'title_prefix_en'=>'DYD-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dyd.nise.asm', 'institute_id' => 1, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DYD-ASM' , 'title_prefix_en'=>'DYD-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht.nise.gov.bd', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT' , 'title_prefix_en'=>'SIDCHT', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht-dev.nise3.xyz', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT-DEV' , 'title_prefix_en'=>'SIDCHT-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'sidcht.nise.asm', 'institute_id' => 2, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SIDCHT-ASM' , 'title_prefix_en'=>'SIDCHT-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI' , 'title_prefix_en'=>'MCCI', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI-DEV' , 'title_prefix_en'=>'MCCI-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'mcci.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 1,'title_prefix'=>'MCCI-ASM' , 'title_prefix_en'=>'MCCI-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB' , 'title_prefix_en'=>'NASCIB', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB-DEV' , 'title_prefix_en'=>'NASCIB-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nascib.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 2,'title_prefix'=>'NASCIB-ASM' , 'title_prefix_en'=>'NASCIB-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF' , 'title_prefix_en'=>'SMEF', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-DEV' , 'title_prefix_en'=>'SMEF-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'smef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-ASM' , 'title_prefix_en'=>'SMEF-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss.nise.gov.bd', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS' , 'title_prefix_en'=>'DSS', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss-dev.nise3.xyz', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS-DEV' , 'title_prefix_en'=>'DSS-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'dss.nise.asm', 'institute_id' => 6, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'DSS-ASM' , 'title_prefix_en'=>'DSS-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno.nise.gov.bd', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO' , 'title_prefix_en'=>'SWAPNO', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno-dev.nise3.xyz', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-DEV' , 'title_prefix_en'=>'SWAPNO-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno.nise.asm', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-ASM' , 'title_prefix_en'=>'SWAPNO-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno.nise.gov.bd', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO' , 'title_prefix_en'=>'SWAPNO', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno-dev.nise3.xyz', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-DEV' , 'title_prefix_en'=>'SWAPNO-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'swapno.nise.asm', 'institute_id' => 8, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SWAPNO-ASM' , 'title_prefix_en'=>'SWAPNO-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp.nise.gov.bd', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP' , 'title_prefix_en'=>'NUPRP', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp-dev.nise3.xyz', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP-DEV' , 'title_prefix_en'=>'NUPRP-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'nuprp.nise.asm', 'institute_id' => 10, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'NUPRP-ASM' , 'title_prefix_en'=>'NUPRP-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation.nise.gov.bd', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION' , 'title_prefix_en'=>'FUTURENATION', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation-dev.nise3.xyz', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION-DEV' , 'title_prefix_en'=>'FUTURENATION-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'futurenation.nise.asm', 'institute_id' => 13, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'FUTURENATION-ASM' , 'title_prefix_en'=>'FUTURENATION-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing.nise.gov.bd', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING' , 'title_prefix_en'=>'WING', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing-dev.nise3.xyz', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING-DEV' , 'title_prefix_en'=>'WING-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'wing.nise.asm', 'institute_id' => 18, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'WING-ASM' , 'title_prefix_en'=>'WING-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb.nise.gov.bd', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB' , 'title_prefix_en'=>'IDEB', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb-dev.nise3.xyz', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB-DEV' , 'title_prefix_en'=>'IDEB-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ideb.nise.asm', 'institute_id' => 20, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'IDEB-ASM' , 'title_prefix_en'=>'IDEB-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl.nise.gov.bd', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL' , 'title_prefix_en'=>'RPL', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl-dev.nise3.xyz', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL-DEV' , 'title_prefix_en'=>'RPL-DEV', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'rpl.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'RPL-ASM' , 'title_prefix_en'=>'RPL-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
            array('domain' => 'ssp-training.nise3.xyz', 'institute_id' => 47, 'organization_id' => NULL, 'industry_association_id' => NULL,'title_prefix'=>'SSP-Training' , 'title_prefix_en'=>'SSP-Training', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34'),
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
