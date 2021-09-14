<?php

namespace Database\Factories;

use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        $isYoutubeVideo = 0;
        $contentPath = $this->faker->sentence();
        $youtubeVideoId = null;
        $contentType = $this->faker->randomElement([1, 2]);
        if ($contentType == 2) {
            $isYoutubeVideo = $this->faker->boolean;
            if ($isYoutubeVideo) {
                $youtubeVideoId = "4qQW1uSoxRg";
            }
        }

        return [

            'content_type' => $contentType,
            'content_title' => $this->faker->jobTitle(),
            'content_path' => $contentPath,
            'institute_id' => $this->faker->numberBetween(1, 10),
            'is_youtube_video' => $isYoutubeVideo,
            'publish_date' => Carbon::yesterday(),
            'archive_date' => carbon::now(),
            'you_tube_video_id' => $youtubeVideoId

        ];
    }
}
