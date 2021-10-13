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
        $name=$this->faker->unique->name;
        $userName=str_replace(" ","_",$name);
    	return [
            'name_en' => $name,
            'name' => $name,
            'email' => $this->faker->safeEmail(),
            'username' => $userName,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
    	];
    }
}
