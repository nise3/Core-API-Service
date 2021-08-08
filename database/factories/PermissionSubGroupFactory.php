<?php

namespace Database\Factories;

use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionSubGroupFactory extends Factory
{
    protected $model = PermissionSubGroup::class;

    public function definition(): array
    {
        /** @var PermissionGroup $permissionGroup */
        $permissionGroup = PermissionGroup::all()->random();
        $title = $this->faker->unique()->jobTitle;
        $key = strtolower(str_replace(' ', '_', $title));
        return [
            'permission_group_id' => $permissionGroup->id,
            'title_en' => ucwords($title . ' en'),
            'title_bn' => ucwords($title . ' bn'),
            'key' => $key
        ];
    }
}
