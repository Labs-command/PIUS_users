<?php

namespace Database\Factories;

use App\Models\UserRoles;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRoles>
 */

class UserRolesFactory extends Factory
{
    protected $model = UserRoles::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return Users::factory()->create()->user_id;
            },
            'role' => $this->faker->randomElement(['admin', 'user']),
        ];
    }
}
