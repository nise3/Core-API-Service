<?php

namespace Database\Factories;

use App\Models\GalleryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryCategoryFactory extends Factory
{
    protected $model = GalleryCategory::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'title_en' => ucfirst($title),
            'title_bn' => ucfirst($title),
            'institute_id' => $this->faker->numberBetween(1, 10),
            'organization_id' => $this->faker->numberBetween(1, 10),
            'batch_id' => $this->faker->numberBetween(1, 10),
            'programme_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->sentence(),
            'featured' => $this->faker->boolean()
        ];
    }
}
