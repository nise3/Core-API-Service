<?php

namespace Database\Seeders;

use App\Models\RecentActivity;
use Illuminate\Database\Seeder;

class RecentActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecentActivity::factory()->count(10)->create();
    }
}
