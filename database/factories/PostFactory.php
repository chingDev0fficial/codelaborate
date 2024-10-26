<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class; // Specify the model that this factory is for

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'nature', true),
            'user_id' => User::factory(), // Assuming there's a UserFactory
        ];
    }
}
