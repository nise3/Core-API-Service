<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaticPageFactory extends Factory
{
    protected $model = StaticPage::class;

    public function definition(): array
    {
        $title = $this->faker->jobTitle();
        return [
            'institute_id' =>  $this->faker->numberBetween(1,10),
            'page_id' => $this->faker->sentence(),
            'page_contents' => $this->faker->sentence(20),
            'title_en' => $title,
            'title_bn' => $title,
        ];
    }
}
