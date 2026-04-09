<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // return [
        //     //
        //     'name' => $this->faker->unique()->randomElement([
        //         'Admin',
        //         'Director',
        //         'Staff',
        //         'VC',
        //         'Super Admin'
        //     ]),
        //     'slug' => $this->faker->unique()->randomElement([
        //         'admin',
        //         'director',
        //         'staff',
        //         'vc',
        //         'super_admin'
        //     ]),
        // ];
        return [
            'name' => fake()->name(),
            'slug' => fake()->name(),
        ];
    }
}
