<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LocDivisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('loc_divisions')->truncate();

        \DB::table('loc_divisions')->insert(array (
            0 =>
            array (
                'bbs_code' => '10',
                'deleted_at' => NULL,
                'id' => 1,
                'title' => 'বরিশাল',
                'title_en' => 'Barisal',
            ),
            1 =>
            array (
                'bbs_code' => '20',
                'deleted_at' => NULL,
                'id' => 2,
                'title' => 'চট্টগ্রাম',
                'title_en' => 'Chittagong',
            ),
            2 =>
            array (
                'bbs_code' => '30',
                'deleted_at' => NULL,
                'id' => 3,
                'title' => 'ঢাকা',
                'title_en' => 'Dhaka',
            ),
            3 =>
            array (
                'bbs_code' => '40',
                'deleted_at' => NULL,
                'id' => 4,
                'title' => 'খুলনা',
                'title_en' => 'Khulna',
            ),
            4 =>
            array (
                'bbs_code' => '50',
                'deleted_at' => NULL,
                'id' => 5,
                'title' => 'রাজশাহী',
                'title_en' => 'Rajshahi',
            ),
            5 =>
            array (
                'bbs_code' => '60',
                'deleted_at' => NULL,
                'id' => 6,
                'title' => 'রংপুর',
                'title_en' => 'Rangpur',
            ),
            6 =>
            array (
                'bbs_code' => '70',
                'deleted_at' => NULL,
                'id' => 7,
                'title' => 'সিলেট',
                'title_en' => 'Sylhet',
            ),
            7 =>
            array (
                'bbs_code' => '45',
                'deleted_at' => NULL,
                'id' => 8,
                'title' => 'ময়মনসিংহ',
                'title_en' => 'Mymensingh',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
