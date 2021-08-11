<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * Class UserFactory
 * @package Database\Factories
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->jobTitle;
        $key = strtolower(str_replace(' ', '_', $title));

    	return [
            'key' => $key,
            'title_en' => ucwords($title . ' en'),
            'title_bn' => ucwords($title . ' bn'),
            'permission_group_id' => null,
            'organization_id' => null,
            'institute_id' => null,
    	];
    }
}
