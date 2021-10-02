<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        $videoType = $this->faker->randomElement([1,2]);
        $uploadedVideoPath = null;
        $youtubeVideoId = null;
        $youtubeVideoUrl= null;
        if ($videoType == 1) {
            $youtubeVideoId = "5g0x2xv3aHU";
            $youtubeVideoUrl= "www.youtube.com/watch?v=5g0x2xv3aHU&t=5661s";
        }
        else{
            $uploadedVideoPath = "storage/video";
        }

        $title = $this->faker->jobTitle();
        return [
            'institute_id'=> $this->faker->numberBetween(1,10),
            'title_en'=>$title,
            'title_bn'=>$title,
            'description_en'=>$this->faker->sentence(20),
            'description_bn'=>$this->faker->sentence(20),
            'video_type'=>$videoType,
            'youtube_video_id'=>$youtubeVideoId,
            'uploaded_video_path'=>$uploadedVideoPath,
            'youtube_video_url'=>$youtubeVideoUrl





    	];
    }
}
