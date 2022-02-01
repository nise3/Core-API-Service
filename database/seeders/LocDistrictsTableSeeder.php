<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LocDistrictsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('loc_districts')->truncate();

        \DB::table('loc_districts')->insert(array (
            0 =>
            array (
                'bbs_code' => '04',
                'deleted_at' => NULL,
                'id' => 1,
                'is_sadar_district' => 0,
                'loc_division_id' => 1,
                'title' => 'বরগুনা',
                'title_en' => 'BARGUNA',
            ),
            1 =>
            array (
                'bbs_code' => '06',
                'deleted_at' => NULL,
                'id' => 2,
                'is_sadar_district' => 1,
                'loc_division_id' => 1,
                'title' => 'বরিশাল',
                'title_en' => 'BARISAL',
            ),
            2 =>
            array (
                'bbs_code' => '09',
                'deleted_at' => NULL,
                'id' => 3,
                'is_sadar_district' => 0,
                'loc_division_id' => 1,
                'title' => 'ভোলা',
                'title_en' => 'BHOLA',
            ),
            3 =>
            array (
                'bbs_code' => '42',
                'deleted_at' => NULL,
                'id' => 4,
                'is_sadar_district' => 0,
                'loc_division_id' => 1,
                'title' => 'ঝালকাঠি',
                'title_en' => 'JHALOKATI',
            ),
            4 =>
            array (
                'bbs_code' => '78',
                'deleted_at' => NULL,
                'id' => 5,
                'is_sadar_district' => 0,
                'loc_division_id' => 1,
                'title' => 'পটুয়াখালী ',
                'title_en' => 'PATUAKHALI',
            ),
            5 =>
            array (
                'bbs_code' => '79',
                'deleted_at' => NULL,
                'id' => 6,
                'is_sadar_district' => 0,
                'loc_division_id' => 1,
                'title' => 'পিরোজপুর ',
                'title_en' => 'PIROJPUR',
            ),
            6 =>
            array (
                'bbs_code' => '03',
                'deleted_at' => NULL,
                'id' => 7,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'বান্দরবান',
                'title_en' => 'BANDARBAN',
            ),
            7 =>
            array (
                'bbs_code' => '12',
                'deleted_at' => NULL,
                'id' => 8,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'ব্রাহ্মণবাড়িয়া',
                'title_en' => 'BRAHMANBARIA',
            ),
            8 =>
            array (
                'bbs_code' => '13',
                'deleted_at' => NULL,
                'id' => 9,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'চাঁদপুর',
                'title_en' => 'CHANDPUR',
            ),
            9 =>
            array (
                'bbs_code' => '15',
                'deleted_at' => NULL,
                'id' => 10,
                'is_sadar_district' => 1,
                'loc_division_id' => 2,
                'title' => 'চট্টগ্রাম',
                'title_en' => 'CHITTAGONG',
            ),
            10 =>
            array (
                'bbs_code' => '19',
                'deleted_at' => NULL,
                'id' => 11,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'কুমিল্লা',
                'title_en' => 'COMILLA',
            ),
            11 =>
            array (
                'bbs_code' => '22',
                'deleted_at' => NULL,
                'id' => 12,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'কক্সবাজার ',
                'title_en' => 'COX\'S BAZAR',
            ),
            12 =>
            array (
                'bbs_code' => '30',
                'deleted_at' => NULL,
                'id' => 13,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'ফেনী',
                'title_en' => 'FENI',
            ),
            13 =>
            array (
                'bbs_code' => '46',
                'deleted_at' => NULL,
                'id' => 14,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'খাগড়াছড়ি',
                'title_en' => 'KHAGRACHHARI',
            ),
            14 =>
            array (
                'bbs_code' => '51',
                'deleted_at' => NULL,
                'id' => 15,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'লক্ষ্মীপুর',
                'title_en' => 'LAKSHMIPUR',
            ),
            15 =>
            array (
                'bbs_code' => '75',
                'deleted_at' => NULL,
                'id' => 16,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'নোয়াখালী',
                'title_en' => 'NOAKHALI',
            ),
            16 =>
            array (
                'bbs_code' => '84',
                'deleted_at' => NULL,
                'id' => 17,
                'is_sadar_district' => 0,
                'loc_division_id' => 2,
                'title' => 'রাঙ্গামাটি',
                'title_en' => 'RANGAMATI',
            ),
            17 =>
            array (
                'bbs_code' => '26',
                'deleted_at' => NULL,
                'id' => 18,
                'is_sadar_district' => 1,
                'loc_division_id' => 3,
                'title' => 'ঢাকা ',
                'title_en' => 'DHAKA',
            ),
            18 =>
            array (
                'bbs_code' => '29',
                'deleted_at' => NULL,
                'id' => 19,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'ফরিদপুর ',
                'title_en' => 'FARIDPUR',
            ),
            19 =>
            array (
                'bbs_code' => '33',
                'deleted_at' => NULL,
                'id' => 20,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'গাজীপুর ',
                'title_en' => 'GAZIPUR',
            ),
            20 =>
            array (
                'bbs_code' => '35',
                'deleted_at' => NULL,
                'id' => 21,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'গোপালগঞ্জ',
                'title_en' => 'GOPALGANJ',
            ),
            21 =>
            array (
                'bbs_code' => '39',
                'deleted_at' => NULL,
                'id' => 22,
                'is_sadar_district' => 0,
                'loc_division_id' => 8,
                'title' => 'জামালপুর ',
                'title_en' => 'JAMALPUR',
            ),
            22 =>
            array (
                'bbs_code' => '48',
                'deleted_at' => NULL,
                'id' => 23,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'কিশোরগঞ্জ ',
                'title_en' => 'KISHOREGONJ',
            ),
            23 =>
            array (
                'bbs_code' => '54',
                'deleted_at' => NULL,
                'id' => 24,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'মাদারীপুর ',
                'title_en' => 'MADARIPUR',
            ),
            24 =>
            array (
                'bbs_code' => '56',
                'deleted_at' => NULL,
                'id' => 25,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'মানিকগঞ্জ ',
                'title_en' => 'MANIKGANJ',
            ),
            25 =>
            array (
                'bbs_code' => '59',
                'deleted_at' => NULL,
                'id' => 26,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'মুন্সিগঞ্জ ',
                'title_en' => 'MUNSHIGANJ',
            ),
            26 =>
            array (
                'bbs_code' => '61',
                'deleted_at' => NULL,
                'id' => 27,
                'is_sadar_district' => 1,
                'loc_division_id' => 8,
                'title' => 'ময়মনসিংহ ',
                'title_en' => 'MYMENSINGH',
            ),
            27 =>
            array (
                'bbs_code' => '67',
                'deleted_at' => NULL,
                'id' => 28,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'নারায়ণগঞ্জ ',
                'title_en' => 'NARAYANGANJ',
            ),
            28 =>
            array (
                'bbs_code' => '68',
                'deleted_at' => NULL,
                'id' => 29,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'নরসিংদী ',
                'title_en' => 'NARSINGDI',
            ),
            29 =>
            array (
                'bbs_code' => '72',
                'deleted_at' => NULL,
                'id' => 30,
                'is_sadar_district' => 0,
                'loc_division_id' => 8,
                'title' => 'নেত্রকোণা ',
                'title_en' => 'NETRAKONA',
            ),
            30 =>
            array (
                'bbs_code' => '82',
                'deleted_at' => NULL,
                'id' => 31,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'রাজবাড়ী ',
                'title_en' => 'RAJBARI',
            ),
            31 =>
            array (
                'bbs_code' => '86',
                'deleted_at' => NULL,
                'id' => 32,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'শরীয়তপুর  ',
                'title_en' => 'SHARIATPUR',
            ),
            32 =>
            array (
                'bbs_code' => '89',
                'deleted_at' => NULL,
                'id' => 33,
                'is_sadar_district' => 0,
                'loc_division_id' => 8,
                'title' => 'শেরপুর ',
                'title_en' => 'SHERPUR',
            ),
            33 =>
            array (
                'bbs_code' => '93',
                'deleted_at' => NULL,
                'id' => 34,
                'is_sadar_district' => 0,
                'loc_division_id' => 3,
                'title' => 'টাঙ্গাইল ',
                'title_en' => 'TANGAIL',
            ),
            34 =>
            array (
                'bbs_code' => '01',
                'deleted_at' => NULL,
                'id' => 35,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'বাগেরহাট',
                'title_en' => 'BAGERHAT',
            ),
            35 =>
            array (
                'bbs_code' => '18',
                'deleted_at' => NULL,
                'id' => 36,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'চুয়াডাঙ্গা ',
                'title_en' => 'CHUADANGA',
            ),
            36 =>
            array (
                'bbs_code' => '41',
                'deleted_at' => NULL,
                'id' => 37,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'যশোর',
                'title_en' => 'JESSORE',
            ),
            37 =>
            array (
                'bbs_code' => '44',
                'deleted_at' => NULL,
                'id' => 38,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'ঝিনাইদহ ',
                'title_en' => 'JHENAIDAH',
            ),
            38 =>
            array (
                'bbs_code' => '47',
                'deleted_at' => NULL,
                'id' => 39,
                'is_sadar_district' => 1,
                'loc_division_id' => 4,
                'title' => 'খুলনা ',
                'title_en' => 'KHULNA',
            ),
            39 =>
            array (
                'bbs_code' => '50',
                'deleted_at' => NULL,
                'id' => 40,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'কুষ্টিয়া ',
                'title_en' => 'KUSHTIA',
            ),
            40 =>
            array (
                'bbs_code' => '55',
                'deleted_at' => NULL,
                'id' => 41,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'মাগুরা',
                'title_en' => 'MAGURA',
            ),
            41 =>
            array (
                'bbs_code' => '57',
                'deleted_at' => NULL,
                'id' => 42,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'মেহেরপুর ',
                'title_en' => 'MEHERPUR',
            ),
            42 =>
            array (
                'bbs_code' => '65',
                'deleted_at' => NULL,
                'id' => 43,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'নড়াইল ',
                'title_en' => 'NARAIL',
            ),
            43 =>
            array (
                'bbs_code' => '87',
                'deleted_at' => NULL,
                'id' => 44,
                'is_sadar_district' => 0,
                'loc_division_id' => 4,
                'title' => 'সাতক্ষীরা ',
                'title_en' => 'SATKHIRA',
            ),
            44 =>
            array (
                'bbs_code' => '10',
                'deleted_at' => NULL,
                'id' => 45,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'বগুড়া ',
                'title_en' => 'BOGRA',
            ),
            45 =>
            array (
                'bbs_code' => '38',
                'deleted_at' => NULL,
                'id' => 46,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'জয়পুরহাট',
                'title_en' => 'JOYPURHAT',
            ),
            46 =>
            array (
                'bbs_code' => '64',
                'deleted_at' => NULL,
                'id' => 47,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'নওগাঁ ',
                'title_en' => 'NAOGAON',
            ),
            47 =>
            array (
                'bbs_code' => '69',
                'deleted_at' => NULL,
                'id' => 48,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'নাটোর ',
                'title_en' => 'NATORE',
            ),
            48 =>
            array (
                'bbs_code' => '70',
                'deleted_at' => NULL,
                'id' => 49,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'চাঁপাই নাবাবগঞ্জ ',
                'title_en' => 'CHAPAI NABABGANJ',
            ),
            49 =>
            array (
                'bbs_code' => '76',
                'deleted_at' => NULL,
                'id' => 50,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'পাবনা',
                'title_en' => 'PABNA',
            ),
            50 =>
            array (
                'bbs_code' => '81',
                'deleted_at' => NULL,
                'id' => 51,
                'is_sadar_district' => 1,
                'loc_division_id' => 5,
                'title' => 'রাজশাহী ',
                'title_en' => 'RAJSHAHI',
            ),
            51 =>
            array (
                'bbs_code' => '88',
                'deleted_at' => NULL,
                'id' => 52,
                'is_sadar_district' => 0,
                'loc_division_id' => 5,
                'title' => 'সিরাজগঞ্জ',
                'title_en' => 'SIRAJGANJ',
            ),
            52 =>
            array (
                'bbs_code' => '27',
                'deleted_at' => NULL,
                'id' => 53,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'দিনাজপুর ',
                'title_en' => 'DINAJPUR',
            ),
            53 =>
            array (
                'bbs_code' => '32',
                'deleted_at' => NULL,
                'id' => 54,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'গাইবান্ধা ',
                'title_en' => 'GAIBANDHA',
            ),
            54 =>
            array (
                'bbs_code' => '49',
                'deleted_at' => NULL,
                'id' => 55,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'কুড়িগ্রাম ',
                'title_en' => 'KURIGRAM',
            ),
            55 =>
            array (
                'bbs_code' => '52',
                'deleted_at' => NULL,
                'id' => 56,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'লালমনিরহাট ',
                'title_en' => 'LALMONIRHAT',
            ),
            56 =>
            array (
                'bbs_code' => '73',
                'deleted_at' => NULL,
                'id' => 57,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'নীলফামারী',
                'title_en' => 'NILPHAMARI',
            ),
            57 =>
            array (
                'bbs_code' => '77',
                'deleted_at' => NULL,
                'id' => 58,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'পঞ্চগড় ',
                'title_en' => 'PANCHAGARH',
            ),
            58 =>
            array (
                'bbs_code' => '85',
                'deleted_at' => NULL,
                'id' => 59,
                'is_sadar_district' => 1,
                'loc_division_id' => 6,
                'title' => 'রংপুর ',
                'title_en' => 'RANGPUR',
            ),
            59 =>
            array (
                'bbs_code' => '94',
                'deleted_at' => NULL,
                'id' => 60,
                'is_sadar_district' => 0,
                'loc_division_id' => 6,
                'title' => 'ঠাকুরগাঁও',
                'title_en' => 'THAKURGAON',
            ),
            60 =>
            array (
                'bbs_code' => '36',
                'deleted_at' => NULL,
                'id' => 61,
                'is_sadar_district' => 0,
                'loc_division_id' => 7,
                'title' => 'হবিগঞ্জ ',
                'title_en' => 'HABIGANJ',
            ),
            61 =>
            array (
                'bbs_code' => '58',
                'deleted_at' => NULL,
                'id' => 62,
                'is_sadar_district' => 0,
                'loc_division_id' => 7,
                'title' => 'মৌলভীবাজার ',
                'title_en' => 'MAULVIBAZAR',
            ),
            62 =>
            array (
                'bbs_code' => '90',
                'deleted_at' => NULL,
                'id' => 63,
                'is_sadar_district' => 0,
                'loc_division_id' => 7,
                'title' => 'সুনামগঞ্জ ',
                'title_en' => 'SUNAMGANJ',
            ),
            63 =>
            array (
                'bbs_code' => '91',
                'deleted_at' => NULL,
                'id' => 64,
                'is_sadar_district' => 1,
                'loc_division_id' => 7,
                'title' => 'সিলেট',
                'title_en' => 'SYLHET',
            ),
        ));

        Schema::enableForeignKeyConstraints();


    }
}
