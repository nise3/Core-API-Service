<?php

namespace Database\Factories;

use App\Models\PermissionSubGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionSubGroupFactory extends Factory
{
    protected $model = PermissionSubGroup::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->jobTitle;
        $key = strtolower(str_replace(' ', '_', $title));
        return [
            'title_en' => ucwords($title . ' en'),
            'title_bn' => ucwords($title . ' bn'),
            'key' => $key
        ];

    }
}
