<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserFactory
 * @package Database\Factories
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        /** @var  Role $role */
        $role = Role::all()->random();
    	return [
            'role_id' => $role->id,
            'name_en' => $this->faker->name,
            'name_bn' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
    	];
    }
}
