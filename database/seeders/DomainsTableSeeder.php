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
            array('domain' => 'smef.nise.asm', 'institute_id' => NULL, 'organization_id' => NULL, 'industry_association_id' => 3,'title_prefix'=>'SMEF-ASM' , 'title_prefix_en'=>'SMEF-ASM', 'created_at' => '2022-01-30 18:00:34', 'updated_at' => '2022-01-30 18:00:34')
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
