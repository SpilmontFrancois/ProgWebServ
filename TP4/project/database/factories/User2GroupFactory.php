<?php

namespace Database\Factories;

use App\Models\User2group;
use Illuminate\Database\Eloquent\Factories\Factory;

class User2GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User2group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'isAdmin' => $this->faker->numberBetween(0, 1)
        ];
    }
}
