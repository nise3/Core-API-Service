<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Database\Seeder;

class VideoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VideoCategory::factory()
            ->has(Video::factory()->count(2))
            ->count(10)
            ->create();
    }
}
