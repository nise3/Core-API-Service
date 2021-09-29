<?php

namespace Database\Seeders;

use App\Models\NoticeOrNews;
use Illuminate\Database\Seeder;

class NoticeOrNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NoticeOrNews::factory()->count(10)->create();
    }
}
