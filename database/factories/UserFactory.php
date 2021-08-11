<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Internet;
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
        $this->faker->addProvider(new Internet( $this->faker));
    	return [
            'name_en' => $this->faker->name,
            'name_bn' => $this->faker->name,
            'email' => $this->faker->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
    	];
    }
}
