<?php

namespace Database\Factories;

use App\Model;
use App\Models\LocDivision;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocDivisionFactory extends Factory
{
    protected $model = LocDivision::class;

    public function definition(): array
    {
    	return [
                "title_en" => $this->faker->title,
                "title_bn" =>  $this->faker->title,
                "bbs_code" => $this->faker->randomDigit()
    	];
    }
}
