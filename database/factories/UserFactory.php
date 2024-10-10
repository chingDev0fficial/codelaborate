<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $developerJobs = [
            "Student",
            "Teacher",
            'Software Developer',
            'Full Stack Developer',
            'Front-end Developer',
            'Back-end Developer',
            'Mobile App Developer',
            'DevOps Engineer',
            'Data Scientist',
            'Machine Learning Engineer',
            'Web Developer',
            'Game Developer',
            'Embedded Systems Developer',
            'AI Developer',
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'birthday' => fake()->date('Y-m-d', '-18 years'),
            'sex' => fake()->randomElement(['male', 'female']),
            'occupation' => fake()->randomElement($developerJobs),
            'profile_picture' => fake()->imageUrl(200, 200, 'people', true, 'Faker'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
