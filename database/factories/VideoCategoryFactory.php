<?php

namespace Database\Factories;

use App\Models\VideoCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoCategoryFactory extends Factory
{
    protected $model = VideoCategory::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'title_en' => ucfirst($title),
            'title_bn' => ucfirst($title),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'parent_id' => $this->faker->randomElement([null, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
        ];
    }
}
