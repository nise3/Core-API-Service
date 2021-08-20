<?php

namespace Database\Factories;

use App\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionGroupFactory extends Factory
{
    protected $model = PermissionGroup::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->jobTitle;
        $key = strtolower(str_replace(' ', '_', $title));
    	return [
            'title_en' =>  ucwords($title.' en'),
            'title_bn' =>  ucwords($title.' bn'),
            'key' => $key
    	];
    }
}
