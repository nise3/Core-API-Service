<?php

namespace Database\Factories;

use App\Models\RecentActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecentActivityFactory extends Factory
{
    protected $model = RecentActivity::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'title_en' => $title,
            'title_bn' => $title,
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'description_en' => $this->faker->sentence(40),
            'description_bn' => $this->faker->sentence(40),
            'content_type' => $this->faker->randomElement([1, 2,3]),
            "content_path" => $this->faker->sentence(),
            "content_properties" => $this->faker->sentence(),
            'alt_title_en' => $this->faker->word(),
            'alt_title_bn' => $this->faker->word(),

        ];
    }
}
