<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PermissionGroupPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        Schema::disableForeignKeyConstraints();

        DB::table('permission_group_permissions')->truncate();

        DB::table('permission_group_permissions')->insert([
            array('permission_group_id' => '1', 'permission_id' => '1'),
            array('permission_group_id' => '1', 'permission_id' => '2'),
            array('permission_group_id' => '1', 'permission_id' => '3'),
            array('permission_group_id' => '1', 'permission_id' => '4'),
            array('permission_group_id' => '1', 'permission_id' => '5'),
            array('permission_group_id' => '1', 'permission_id' => '6'),
            array('permission_group_id' => '1', 'permission_id' => '7'),
            array('permission_group_id' => '1', 'permission_id' => '8'),
            array('permission_group_id' => '1', 'permission_id' => '9'),
            array('permission_group_id' => '1', 'permission_id' => '10'),
            array('permission_group_id' => '1', 'permission_id' => '11'),
            array('permission_group_id' => '1', 'permission_id' => '12'),
            array('permission_group_id' => '1', 'permission_id' => '13'),
            array('permission_group_id' => '1', 'permission_id' => '14'),
            array('permission_group_id' => '1', 'permission_id' => '15'),
            array('permission_group_id' => '1', 'permission_id' => '16'),
            array('permission_group_id' => '1', 'permission_id' => '17'),
            array('permission_group_id' => '1', 'permission_id' => '18'),
            array('permission_group_id' => '1', 'permission_id' => '19'),
            array('permission_group_id' => '1', 'permission_id' => '20'),
            array('permission_group_id' => '1', 'permission_id' => '21'),
            array('permission_group_id' => '1', 'permission_id' => '22'),
            array('permission_group_id' => '1', 'permission_id' => '23'),
            array('permission_group_id' => '1', 'permission_id' => '24'),
            array('permission_group_id' => '1', 'permission_id' => '25'),
            array('permission_group_id' => '1', 'permission_id' => '26'),
            array('permission_group_id' => '1', 'permission_id' => '27'),
            array('permission_group_id' => '1', 'permission_id' => '28'),
            array('permission_group_id' => '1', 'permission_id' => '29'),
            array('permission_group_id' => '1', 'permission_id' => '30'),
            array('permission_group_id' => '1', 'permission_id' => '31'),
            array('permission_group_id' => '1', 'permission_id' => '32'),
            array('permission_group_id' => '1', 'permission_id' => '33'),
            array('permission_group_id' => '1', 'permission_id' => '34'),
            array('permission_group_id' => '1', 'permission_id' => '35'),
            array('permission_group_id' => '1', 'permission_id' => '36'),
            array('permission_group_id' => '1', 'permission_id' => '37'),
            array('permission_group_id' => '1', 'permission_id' => '38'),
            array('permission_group_id' => '1', 'permission_id' => '39'),
            array('permission_group_id' => '1', 'permission_id' => '40'),
            array('permission_group_id' => '1', 'permission_id' => '41'),
            array('permission_group_id' => '1', 'permission_id' => '42'),
            array('permission_group_id' => '1', 'permission_id' => '43'),
            array('permission_group_id' => '1', 'permission_id' => '44'),
            array('permission_group_id' => '1', 'permission_id' => '45'),
            array('permission_group_id' => '1', 'permission_id' => '46'),
            array('permission_group_id' => '1', 'permission_id' => '47'),
            array('permission_group_id' => '1', 'permission_id' => '48'),
            array('permission_group_id' => '1', 'permission_id' => '49'),
            array('permission_group_id' => '1', 'permission_id' => '50'),
            array('permission_group_id' => '1', 'permission_id' => '51'),
            array('permission_group_id' => '1', 'permission_id' => '52'),
            array('permission_group_id' => '1', 'permission_id' => '53'),
            array('permission_group_id' => '1', 'permission_id' => '54'),
            array('permission_group_id' => '1', 'permission_id' => '55'),
            array('permission_group_id' => '1', 'permission_id' => '56'),
            array('permission_group_id' => '1', 'permission_id' => '57'),
            array('permission_group_id' => '1', 'permission_id' => '58'),
            array('permission_group_id' => '1', 'permission_id' => '59'),
            array('permission_group_id' => '1', 'permission_id' => '60'),
            array('permission_group_id' => '1', 'permission_id' => '61'),
            array('permission_group_id' => '1', 'permission_id' => '62'),
            array('permission_group_id' => '1', 'permission_id' => '63'),
            array('permission_group_id' => '1', 'permission_id' => '64'),
            array('permission_group_id' => '1', 'permission_id' => '65'),
            array('permission_group_id' => '1', 'permission_id' => '66'),
            array('permission_group_id' => '1', 'permission_id' => '67'),
            array('permission_group_id' => '1', 'permission_id' => '68'),
            array('permission_group_id' => '1', 'permission_id' => '69'),
            array('permission_group_id' => '1', 'permission_id' => '70'),
            array('permission_group_id' => '1', 'permission_id' => '71'),
            array('permission_group_id' => '1', 'permission_id' => '72'),
            array('permission_group_id' => '1', 'permission_id' => '73'),
            array('permission_group_id' => '1', 'permission_id' => '74'),
            array('permission_group_id' => '1', 'permission_id' => '75'),
            array('permission_group_id' => '1', 'permission_id' => '76'),
            array('permission_group_id' => '1', 'permission_id' => '77'),
            array('permission_group_id' => '1', 'permission_id' => '78'),
            array('permission_group_id' => '1', 'permission_id' => '79'),
            array('permission_group_id' => '1', 'permission_id' => '80'),
            array('permission_group_id' => '1', 'permission_id' => '81'),
            array('permission_group_id' => '1', 'permission_id' => '82'),
            array('permission_group_id' => '1', 'permission_id' => '83'),
            array('permission_group_id' => '1', 'permission_id' => '84'),
            array('permission_group_id' => '1', 'permission_id' => '85'),
            array('permission_group_id' => '1', 'permission_id' => '86'),
            array('permission_group_id' => '1', 'permission_id' => '87'),
            array('permission_group_id' => '1', 'permission_id' => '88'),
            array('permission_group_id' => '1', 'permission_id' => '89'),
            array('permission_group_id' => '1', 'permission_id' => '90'),
            array('permission_group_id' => '1', 'permission_id' => '91'),
            array('permission_group_id' => '1', 'permission_id' => '92'),
            array('permission_group_id' => '1', 'permission_id' => '93'),
            array('permission_group_id' => '1', 'permission_id' => '94'),
            array('permission_group_id' => '1', 'permission_id' => '95'),
            array('permission_group_id' => '1', 'permission_id' => '96'),
            array('permission_group_id' => '1', 'permission_id' => '97'),
            array('permission_group_id' => '1', 'permission_id' => '98'),
            array('permission_group_id' => '1', 'permission_id' => '99'),
            array('permission_group_id' => '1', 'permission_id' => '100'),
            array('permission_group_id' => '1', 'permission_id' => '101'),
            array('permission_group_id' => '1', 'permission_id' => '102'),
            array('permission_group_id' => '1', 'permission_id' => '103'),
            array('permission_group_id' => '1', 'permission_id' => '104'),
            array('permission_group_id' => '1', 'permission_id' => '105'),
            array('permission_group_id' => '1', 'permission_id' => '111'),
            array('permission_group_id' => '1', 'permission_id' => '112'),
            array('permission_group_id' => '1', 'permission_id' => '113'),
            array('permission_group_id' => '1', 'permission_id' => '114'),
            array('permission_group_id' => '1', 'permission_id' => '115'),
            array('permission_group_id' => '1', 'permission_id' => '116'),
            array('permission_group_id' => '1', 'permission_id' => '117'),
            array('permission_group_id' => '1', 'permission_id' => '118'),
            array('permission_group_id' => '1', 'permission_id' => '119'),
            array('permission_group_id' => '1', 'permission_id' => '120'),
            array('permission_group_id' => '1', 'permission_id' => '121'),
            array('permission_group_id' => '1', 'permission_id' => '122'),
            array('permission_group_id' => '1', 'permission_id' => '123'),
            array('permission_group_id' => '1', 'permission_id' => '124'),
            array('permission_group_id' => '1', 'permission_id' => '125'),
            array('permission_group_id' => '1', 'permission_id' => '126'),
            array('permission_group_id' => '1', 'permission_id' => '127'),
            array('permission_group_id' => '1', 'permission_id' => '128'),
            array('permission_group_id' => '1', 'permission_id' => '129'),
            array('permission_group_id' => '1', 'permission_id' => '130'),
            array('permission_group_id' => '1', 'permission_id' => '131'),
            array('permission_group_id' => '1', 'permission_id' => '132'),
            array('permission_group_id' => '1', 'permission_id' => '133'),
            array('permission_group_id' => '1', 'permission_id' => '134'),
            array('permission_group_id' => '1', 'permission_id' => '135'),
            array('permission_group_id' => '1', 'permission_id' => '141'),
            array('permission_group_id' => '1', 'permission_id' => '142'),
            array('permission_group_id' => '1', 'permission_id' => '143'),
            array('permission_group_id' => '1', 'permission_id' => '144'),
            array('permission_group_id' => '1', 'permission_id' => '145'),
            array('permission_group_id' => '1', 'permission_id' => '146'),
            array('permission_group_id' => '1', 'permission_id' => '147'),
            array('permission_group_id' => '1', 'permission_id' => '148'),
            array('permission_group_id' => '1', 'permission_id' => '149'),
            array('permission_group_id' => '1', 'permission_id' => '150'),
            array('permission_group_id' => '1', 'permission_id' => '151'),
            array('permission_group_id' => '1', 'permission_id' => '152'),
            array('permission_group_id' => '1', 'permission_id' => '153'),
            array('permission_group_id' => '1', 'permission_id' => '154'),
            array('permission_group_id' => '1', 'permission_id' => '155'),
            array('permission_group_id' => '1', 'permission_id' => '156'),
            array('permission_group_id' => '1', 'permission_id' => '157'),
            array('permission_group_id' => '1', 'permission_id' => '158'),
            array('permission_group_id' => '1', 'permission_id' => '159'),
            array('permission_group_id' => '1', 'permission_id' => '160'),
            array('permission_group_id' => '1', 'permission_id' => '161'),
            array('permission_group_id' => '1', 'permission_id' => '162'),
            array('permission_group_id' => '1', 'permission_id' => '163'),
            array('permission_group_id' => '1', 'permission_id' => '164'),
            array('permission_group_id' => '1', 'permission_id' => '165'),
            array('permission_group_id' => '1', 'permission_id' => '166'),
            array('permission_group_id' => '1', 'permission_id' => '167'),
            array('permission_group_id' => '1', 'permission_id' => '168'),
            array('permission_group_id' => '1', 'permission_id' => '169'),
            array('permission_group_id' => '1', 'permission_id' => '170'),
            array('permission_group_id' => '1', 'permission_id' => '171'),
            array('permission_group_id' => '1', 'permission_id' => '172'),
            array('permission_group_id' => '1', 'permission_id' => '173'),
            array('permission_group_id' => '1', 'permission_id' => '174'),
            array('permission_group_id' => '1', 'permission_id' => '175'),
            array('permission_group_id' => '1', 'permission_id' => '176'),
            array('permission_group_id' => '1', 'permission_id' => '177'),
            array('permission_group_id' => '1', 'permission_id' => '178'),
            array('permission_group_id' => '1', 'permission_id' => '179'),
            array('permission_group_id' => '1', 'permission_id' => '180'),
            array('permission_group_id' => '1', 'permission_id' => '181'),
            array('permission_group_id' => '1', 'permission_id' => '182'),
            array('permission_group_id' => '1', 'permission_id' => '183'),
            array('permission_group_id' => '1', 'permission_id' => '184'),
            array('permission_group_id' => '1', 'permission_id' => '185'),
            array('permission_group_id' => '1', 'permission_id' => '186'),
            array('permission_group_id' => '1', 'permission_id' => '187'),
            array('permission_group_id' => '1', 'permission_id' => '188'),
            array('permission_group_id' => '1', 'permission_id' => '189'),
            array('permission_group_id' => '1', 'permission_id' => '190'),
            array('permission_group_id' => '1', 'permission_id' => '191'),
            array('permission_group_id' => '1', 'permission_id' => '192'),
            array('permission_group_id' => '1', 'permission_id' => '193'),
            array('permission_group_id' => '1', 'permission_id' => '194'),
            array('permission_group_id' => '1', 'permission_id' => '195'),
            array('permission_group_id' => '1', 'permission_id' => '196'),
            array('permission_group_id' => '1', 'permission_id' => '197'),
            array('permission_group_id' => '1', 'permission_id' => '198'),
            array('permission_group_id' => '1', 'permission_id' => '199'),
            array('permission_group_id' => '1', 'permission_id' => '200'),
            array('permission_group_id' => '1', 'permission_id' => '201'),
            array('permission_group_id' => '1', 'permission_id' => '202'),
            array('permission_group_id' => '1', 'permission_id' => '203'),
            array('permission_group_id' => '1', 'permission_id' => '204'),
            array('permission_group_id' => '1', 'permission_id' => '205'),
            array('permission_group_id' => '1', 'permission_id' => '206'),
            array('permission_group_id' => '1', 'permission_id' => '207'),
            array('permission_group_id' => '1', 'permission_id' => '208'),
            array('permission_group_id' => '1', 'permission_id' => '209'),
            array('permission_group_id' => '1', 'permission_id' => '210'),
            array('permission_group_id' => '1', 'permission_id' => '211'),
            array('permission_group_id' => '1', 'permission_id' => '212'),
            array('permission_group_id' => '1', 'permission_id' => '213'),
            array('permission_group_id' => '1', 'permission_id' => '214'),
            array('permission_group_id' => '1', 'permission_id' => '215'),
            array('permission_group_id' => '1', 'permission_id' => '216'),
            array('permission_group_id' => '1', 'permission_id' => '217'),
            array('permission_group_id' => '1', 'permission_id' => '218'),
            array('permission_group_id' => '1', 'permission_id' => '219'),
            array('permission_group_id' => '1', 'permission_id' => '220'),
            array('permission_group_id' => '1', 'permission_id' => '221'),
            array('permission_group_id' => '1', 'permission_id' => '222'),
            array('permission_group_id' => '1', 'permission_id' => '223'),
            array('permission_group_id' => '1', 'permission_id' => '224'),
            array('permission_group_id' => '1', 'permission_id' => '238'),
            array('permission_group_id' => '1', 'permission_id' => '239'),
            array('permission_group_id' => '2', 'permission_id' => '16'),
            array('permission_group_id' => '2', 'permission_id' => '17'),
            array('permission_group_id' => '2', 'permission_id' => '18'),
            array('permission_group_id' => '2', 'permission_id' => '19'),
            array('permission_group_id' => '2', 'permission_id' => '20'),
            array('permission_group_id' => '2', 'permission_id' => '21'),
            array('permission_group_id' => '2', 'permission_id' => '22'),
            array('permission_group_id' => '2', 'permission_id' => '23'),
            array('permission_group_id' => '2', 'permission_id' => '24'),
            array('permission_group_id' => '2', 'permission_id' => '25'),
            array('permission_group_id' => '2', 'permission_id' => '101'),
            array('permission_group_id' => '2', 'permission_id' => '102'),
            array('permission_group_id' => '2', 'permission_id' => '103'),
            array('permission_group_id' => '2', 'permission_id' => '104'),
            array('permission_group_id' => '2', 'permission_id' => '105'),
            array('permission_group_id' => '2', 'permission_id' => '106'),
            array('permission_group_id' => '2', 'permission_id' => '107'),
            array('permission_group_id' => '2', 'permission_id' => '108'),
            array('permission_group_id' => '2', 'permission_id' => '109'),
            array('permission_group_id' => '2', 'permission_id' => '110'),
            array('permission_group_id' => '2', 'permission_id' => '111'),
            array('permission_group_id' => '2', 'permission_id' => '112'),
            array('permission_group_id' => '2', 'permission_id' => '113'),
            array('permission_group_id' => '2', 'permission_id' => '114'),
            array('permission_group_id' => '2', 'permission_id' => '115'),
            array('permission_group_id' => '2', 'permission_id' => '121'),
            array('permission_group_id' => '2', 'permission_id' => '122'),
            array('permission_group_id' => '2', 'permission_id' => '123'),
            array('permission_group_id' => '2', 'permission_id' => '124'),
            array('permission_group_id' => '2', 'permission_id' => '125'),
            array('permission_group_id' => '2', 'permission_id' => '126'),
            array('permission_group_id' => '2', 'permission_id' => '127'),
            array('permission_group_id' => '2', 'permission_id' => '128'),
            array('permission_group_id' => '2', 'permission_id' => '129'),
            array('permission_group_id' => '2', 'permission_id' => '130'),
            array('permission_group_id' => '2', 'permission_id' => '131'),
            array('permission_group_id' => '2', 'permission_id' => '132'),
            array('permission_group_id' => '2', 'permission_id' => '133'),
            array('permission_group_id' => '2', 'permission_id' => '134'),
            array('permission_group_id' => '2', 'permission_id' => '135'),
            array('permission_group_id' => '2', 'permission_id' => '136'),
            array('permission_group_id' => '2', 'permission_id' => '137'),
            array('permission_group_id' => '2', 'permission_id' => '138'),
            array('permission_group_id' => '2', 'permission_id' => '139'),
            array('permission_group_id' => '2', 'permission_id' => '140'),
            array('permission_group_id' => '2', 'permission_id' => '156'),
            array('permission_group_id' => '2', 'permission_id' => '157'),
            array('permission_group_id' => '2', 'permission_id' => '158'),
            array('permission_group_id' => '2', 'permission_id' => '159'),
            array('permission_group_id' => '2', 'permission_id' => '160'),
            array('permission_group_id' => '2', 'permission_id' => '161'),
            array('permission_group_id' => '2', 'permission_id' => '162'),
            array('permission_group_id' => '2', 'permission_id' => '163'),
            array('permission_group_id' => '2', 'permission_id' => '164'),
            array('permission_group_id' => '2', 'permission_id' => '165'),
            array('permission_group_id' => '2', 'permission_id' => '166'),
            array('permission_group_id' => '2', 'permission_id' => '167'),
            array('permission_group_id' => '2', 'permission_id' => '168'),
            array('permission_group_id' => '2', 'permission_id' => '169'),
            array('permission_group_id' => '2', 'permission_id' => '170'),
            array('permission_group_id' => '2', 'permission_id' => '171'),
            array('permission_group_id' => '2', 'permission_id' => '172'),
            array('permission_group_id' => '2', 'permission_id' => '173'),
            array('permission_group_id' => '2', 'permission_id' => '174'),
            array('permission_group_id' => '2', 'permission_id' => '175'),
            array('permission_group_id' => '2', 'permission_id' => '176'),
            array('permission_group_id' => '2', 'permission_id' => '177'),
            array('permission_group_id' => '2', 'permission_id' => '178'),
            array('permission_group_id' => '2', 'permission_id' => '179'),
            array('permission_group_id' => '2', 'permission_id' => '180'),
            array('permission_group_id' => '2', 'permission_id' => '186'),
            array('permission_group_id' => '2', 'permission_id' => '187'),
            array('permission_group_id' => '2', 'permission_id' => '188'),
            array('permission_group_id' => '2', 'permission_id' => '189'),
            array('permission_group_id' => '2', 'permission_id' => '190'),
            array('permission_group_id' => '2', 'permission_id' => '191'),
            array('permission_group_id' => '2', 'permission_id' => '192'),
            array('permission_group_id' => '2', 'permission_id' => '193'),
            array('permission_group_id' => '2', 'permission_id' => '194'),
            array('permission_group_id' => '2', 'permission_id' => '196'),
            array('permission_group_id' => '2', 'permission_id' => '197'),
            array('permission_group_id' => '2', 'permission_id' => '198'),
            array('permission_group_id' => '2', 'permission_id' => '199'),
            array('permission_group_id' => '2', 'permission_id' => '200'),
            array('permission_group_id' => '2', 'permission_id' => '201'),
            array('permission_group_id' => '2', 'permission_id' => '202'),
            array('permission_group_id' => '2', 'permission_id' => '203'),
            array('permission_group_id' => '2', 'permission_id' => '204'),
            array('permission_group_id' => '2', 'permission_id' => '205'),
            array('permission_group_id' => '2', 'permission_id' => '206'),
            array('permission_group_id' => '2', 'permission_id' => '207'),
            array('permission_group_id' => '2', 'permission_id' => '208'),
            array('permission_group_id' => '2', 'permission_id' => '209'),
            array('permission_group_id' => '2', 'permission_id' => '210'),
            array('permission_group_id' => '2', 'permission_id' => '211'),
            array('permission_group_id' => '2', 'permission_id' => '212'),
            array('permission_group_id' => '2', 'permission_id' => '213'),
            array('permission_group_id' => '2', 'permission_id' => '214'),
            array('permission_group_id' => '2', 'permission_id' => '215'),
            array('permission_group_id' => '2', 'permission_id' => '221'),
            array('permission_group_id' => '2', 'permission_id' => '222'),
            array('permission_group_id' => '2', 'permission_id' => '223'),
            array('permission_group_id' => '2', 'permission_id' => '224'),
            array('permission_group_id' => '2', 'permission_id' => '225'),
            array('permission_group_id' => '2', 'permission_id' => '226'),
            array('permission_group_id' => '2', 'permission_id' => '232'),
            array('permission_group_id' => '2', 'permission_id' => '233'),
            array('permission_group_id' => '2', 'permission_id' => '238'),
            array('permission_group_id' => '4', 'permission_id' => '16'),
            array('permission_group_id' => '4', 'permission_id' => '17'),
            array('permission_group_id' => '4', 'permission_id' => '18'),
            array('permission_group_id' => '4', 'permission_id' => '19'),
            array('permission_group_id' => '4', 'permission_id' => '20'),
            array('permission_group_id' => '4', 'permission_id' => '21'),
            array('permission_group_id' => '4', 'permission_id' => '22'),
            array('permission_group_id' => '4', 'permission_id' => '23'),
            array('permission_group_id' => '4', 'permission_id' => '24'),
            array('permission_group_id' => '4', 'permission_id' => '25'),
            array('permission_group_id' => '4', 'permission_id' => '156'),
            array('permission_group_id' => '4', 'permission_id' => '157'),
            array('permission_group_id' => '4', 'permission_id' => '158'),
            array('permission_group_id' => '4', 'permission_id' => '159'),
            array('permission_group_id' => '4', 'permission_id' => '160'),
            array('permission_group_id' => '4', 'permission_id' => '161'),
            array('permission_group_id' => '4', 'permission_id' => '162'),
            array('permission_group_id' => '4', 'permission_id' => '163'),
            array('permission_group_id' => '4', 'permission_id' => '164'),
            array('permission_group_id' => '4', 'permission_id' => '165'),
            array('permission_group_id' => '4', 'permission_id' => '166'),
            array('permission_group_id' => '4', 'permission_id' => '167'),
            array('permission_group_id' => '4', 'permission_id' => '168'),
            array('permission_group_id' => '4', 'permission_id' => '169'),
            array('permission_group_id' => '4', 'permission_id' => '170'),
            array('permission_group_id' => '4', 'permission_id' => '171'),
            array('permission_group_id' => '4', 'permission_id' => '172'),
            array('permission_group_id' => '4', 'permission_id' => '173'),
            array('permission_group_id' => '4', 'permission_id' => '174'),
            array('permission_group_id' => '4', 'permission_id' => '175'),
            array('permission_group_id' => '4', 'permission_id' => '176'),
            array('permission_group_id' => '4', 'permission_id' => '177'),
            array('permission_group_id' => '4', 'permission_id' => '178'),
            array('permission_group_id' => '4', 'permission_id' => '179'),
            array('permission_group_id' => '4', 'permission_id' => '180'),
            array('permission_group_id' => '4', 'permission_id' => '186'),
            array('permission_group_id' => '4', 'permission_id' => '187'),
            array('permission_group_id' => '4', 'permission_id' => '188'),
            array('permission_group_id' => '4', 'permission_id' => '189'),
            array('permission_group_id' => '4', 'permission_id' => '190'),
            array('permission_group_id' => '4', 'permission_id' => '191'),
            array('permission_group_id' => '4', 'permission_id' => '192'),
            array('permission_group_id' => '4', 'permission_id' => '193'),
            array('permission_group_id' => '4', 'permission_id' => '194'),
            array('permission_group_id' => '4', 'permission_id' => '195'),
            array('permission_group_id' => '4', 'permission_id' => '196'),
            array('permission_group_id' => '4', 'permission_id' => '197'),
            array('permission_group_id' => '4', 'permission_id' => '198'),
            array('permission_group_id' => '4', 'permission_id' => '199'),
            array('permission_group_id' => '4', 'permission_id' => '200'),
            array('permission_group_id' => '4', 'permission_id' => '201'),
            array('permission_group_id' => '4', 'permission_id' => '202'),
            array('permission_group_id' => '4', 'permission_id' => '203'),
            array('permission_group_id' => '4', 'permission_id' => '204'),
            array('permission_group_id' => '4', 'permission_id' => '205'),
            array('permission_group_id' => '4', 'permission_id' => '211'),
            array('permission_group_id' => '4', 'permission_id' => '212'),
            array('permission_group_id' => '4', 'permission_id' => '213'),
            array('permission_group_id' => '4', 'permission_id' => '214'),
            array('permission_group_id' => '4', 'permission_id' => '215'),
            array('permission_group_id' => '4', 'permission_id' => '229'),
            array('permission_group_id' => '4', 'permission_id' => '230'),
            array('permission_group_id' => '4', 'permission_id' => '231'),
            array('permission_group_id' => '4', 'permission_id' => '238'),
            array('permission_group_id' => '2', 'permission_id' => '195'),
            array('permission_group_id' => '4', 'permission_id' => '206'),
            array('permission_group_id' => '4', 'permission_id' => '207'),
            array('permission_group_id' => '4', 'permission_id' => '208'),
            array('permission_group_id' => '4', 'permission_id' => '209'),
            array('permission_group_id' => '4', 'permission_id' => '210'),
            array('permission_group_id' => '3', 'permission_id' => '16'),
            array('permission_group_id' => '3', 'permission_id' => '17'),
            array('permission_group_id' => '3', 'permission_id' => '18'),
            array('permission_group_id' => '3', 'permission_id' => '19'),
            array('permission_group_id' => '3', 'permission_id' => '20'),
            array('permission_group_id' => '3', 'permission_id' => '21'),
            array('permission_group_id' => '3', 'permission_id' => '22'),
            array('permission_group_id' => '3', 'permission_id' => '23'),
            array('permission_group_id' => '3', 'permission_id' => '24'),
            array('permission_group_id' => '3', 'permission_id' => '25'),
            array('permission_group_id' => '3', 'permission_id' => '47'),
            array('permission_group_id' => '3', 'permission_id' => '146'),
            array('permission_group_id' => '3', 'permission_id' => '147'),
            array('permission_group_id' => '3', 'permission_id' => '148'),
            array('permission_group_id' => '3', 'permission_id' => '149'),
            array('permission_group_id' => '3', 'permission_id' => '150'),
            array('permission_group_id' => '3', 'permission_id' => '151'),
            array('permission_group_id' => '3', 'permission_id' => '152'),
            array('permission_group_id' => '3', 'permission_id' => '153'),
            array('permission_group_id' => '3', 'permission_id' => '154'),
            array('permission_group_id' => '3', 'permission_id' => '155'),
            array('permission_group_id' => '3', 'permission_id' => '156'),
            array('permission_group_id' => '3', 'permission_id' => '157'),
            array('permission_group_id' => '3', 'permission_id' => '158'),
            array('permission_group_id' => '3', 'permission_id' => '159'),
            array('permission_group_id' => '3', 'permission_id' => '160'),
            array('permission_group_id' => '3', 'permission_id' => '161'),
            array('permission_group_id' => '3', 'permission_id' => '162'),
            array('permission_group_id' => '3', 'permission_id' => '163'),
            array('permission_group_id' => '3', 'permission_id' => '164'),
            array('permission_group_id' => '3', 'permission_id' => '165'),
            array('permission_group_id' => '3', 'permission_id' => '166'),
            array('permission_group_id' => '3', 'permission_id' => '167'),
            array('permission_group_id' => '3', 'permission_id' => '168'),
            array('permission_group_id' => '3', 'permission_id' => '169'),
            array('permission_group_id' => '3', 'permission_id' => '170'),
            array('permission_group_id' => '3', 'permission_id' => '171'),
            array('permission_group_id' => '3', 'permission_id' => '172'),
            array('permission_group_id' => '3', 'permission_id' => '173'),
            array('permission_group_id' => '3', 'permission_id' => '174'),
            array('permission_group_id' => '3', 'permission_id' => '175'),
            array('permission_group_id' => '3', 'permission_id' => '176'),
            array('permission_group_id' => '3', 'permission_id' => '177'),
            array('permission_group_id' => '3', 'permission_id' => '178'),
            array('permission_group_id' => '3', 'permission_id' => '179'),
            array('permission_group_id' => '3', 'permission_id' => '180'),
            array('permission_group_id' => '3', 'permission_id' => '186'),
            array('permission_group_id' => '3', 'permission_id' => '187'),
            array('permission_group_id' => '3', 'permission_id' => '188'),
            array('permission_group_id' => '3', 'permission_id' => '189'),
            array('permission_group_id' => '3', 'permission_id' => '190'),
            array('permission_group_id' => '3', 'permission_id' => '191'),
            array('permission_group_id' => '3', 'permission_id' => '192'),
            array('permission_group_id' => '3', 'permission_id' => '193'),
            array('permission_group_id' => '3', 'permission_id' => '194'),
            array('permission_group_id' => '3', 'permission_id' => '195'),
            array('permission_group_id' => '3', 'permission_id' => '196'),
            array('permission_group_id' => '3', 'permission_id' => '197'),
            array('permission_group_id' => '3', 'permission_id' => '198'),
            array('permission_group_id' => '3', 'permission_id' => '199'),
            array('permission_group_id' => '3', 'permission_id' => '200'),
            array('permission_group_id' => '3', 'permission_id' => '201'),
            array('permission_group_id' => '3', 'permission_id' => '202'),
            array('permission_group_id' => '3', 'permission_id' => '203'),
            array('permission_group_id' => '3', 'permission_id' => '204'),
            array('permission_group_id' => '3', 'permission_id' => '205'),
            array('permission_group_id' => '3', 'permission_id' => '206'),
            array('permission_group_id' => '3', 'permission_id' => '207'),
            array('permission_group_id' => '3', 'permission_id' => '208'),
            array('permission_group_id' => '3', 'permission_id' => '209'),
            array('permission_group_id' => '3', 'permission_id' => '210'),
            array('permission_group_id' => '3', 'permission_id' => '211'),
            array('permission_group_id' => '3', 'permission_id' => '212'),
            array('permission_group_id' => '3', 'permission_id' => '213'),
            array('permission_group_id' => '3', 'permission_id' => '214'),
            array('permission_group_id' => '3', 'permission_id' => '215'),
            array('permission_group_id' => '3', 'permission_id' => '216'),
            array('permission_group_id' => '3', 'permission_id' => '217'),
            array('permission_group_id' => '3', 'permission_id' => '218'),
            array('permission_group_id' => '3', 'permission_id' => '219'),
            array('permission_group_id' => '3', 'permission_id' => '220'),
            array('permission_group_id' => '3', 'permission_id' => '228'),
            array('permission_group_id' => '3', 'permission_id' => '229'),
            array('permission_group_id' => '3', 'permission_id' => '230'),
            array('permission_group_id' => '3', 'permission_id' => '231'),
            array('permission_group_id' => '3', 'permission_id' => '236'),
            array('permission_group_id' => '3', 'permission_id' => '237'),
            array('permission_group_id' => '3', 'permission_id' => '238'),
            array('permission_group_id' => '3', 'permission_id' => '240'),
            array('permission_group_id' => '4', 'permission_id' => '51'),
            array('permission_group_id' => '4', 'permission_id' => '52'),
            array('permission_group_id' => '4', 'permission_id' => '53'),
            array('permission_group_id' => '4', 'permission_id' => '54'),
            array('permission_group_id' => '4', 'permission_id' => '55'),
            array('permission_group_id' => '4', 'permission_id' => '56'),
            array('permission_group_id' => '4', 'permission_id' => '57'),
            array('permission_group_id' => '4', 'permission_id' => '58'),
            array('permission_group_id' => '4', 'permission_id' => '59'),
            array('permission_group_id' => '4', 'permission_id' => '60'),
            array('permission_group_id' => '4', 'permission_id' => '81'),
            array('permission_group_id' => '4', 'permission_id' => '82'),
            array('permission_group_id' => '4', 'permission_id' => '83'),
            array('permission_group_id' => '4', 'permission_id' => '84'),
            array('permission_group_id' => '4', 'permission_id' => '85'),
            array('permission_group_id' => '4', 'permission_id' => '86'),
            array('permission_group_id' => '4', 'permission_id' => '87'),
            array('permission_group_id' => '4', 'permission_id' => '88'),
            array('permission_group_id' => '4', 'permission_id' => '89'),
            array('permission_group_id' => '4', 'permission_id' => '90'),
            array('permission_group_id' => '4', 'permission_id' => '91'),
            array('permission_group_id' => '4', 'permission_id' => '92'),
            array('permission_group_id' => '4', 'permission_id' => '93'),
            array('permission_group_id' => '4', 'permission_id' => '94'),
            array('permission_group_id' => '4', 'permission_id' => '95'),
            array('permission_group_id' => '4', 'permission_id' => '96'),
            array('permission_group_id' => '4', 'permission_id' => '97'),
            array('permission_group_id' => '4', 'permission_id' => '98'),
            array('permission_group_id' => '4', 'permission_id' => '99'),
            array('permission_group_id' => '4', 'permission_id' => '100'),
            array('permission_group_id' => '4', 'permission_id' => '234'),
            array('permission_group_id' => '4', 'permission_id' => '235'),
            array('permission_group_id' => '3', 'permission_id' => '227')
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
