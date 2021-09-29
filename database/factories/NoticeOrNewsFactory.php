<?php

namespace Database\Factories;

use App\Models\NoticeOrNews;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeOrNewsFactory extends Factory
{
    protected $model = NoticeOrNews::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'type' => $this->faker->randomElement([1, 2]),
            'title_en' => $title,
            'title_bn' => $title,
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'description_en' => $this->faker->sentence(40),
            'description_bn' => $this->faker->sentence(40),
            'image' => $this->faker->sentence(),
            'file' => $this->faker->sentence(),
            'image_alt_title_en' => $this->faker->word(),
            'image_alt_title_bn' => $this->faker->word(),
            'file_alt_title_en' => $this->faker->word(),
            'file_alt_title_bn' => $this->faker->word(),
        ];
    }
}
