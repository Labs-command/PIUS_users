<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    protected $model = Users::class;

    public function definition()
    {
        return [
            'user_id' => Str::uuid()->toString(),
            'state' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
