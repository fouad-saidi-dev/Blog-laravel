<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = Comment::class;


    public function definition()
    {
        return [
            'content' => $this->faker->text,
            'updated_at' => $this->faker->dateTimeBetween('-1 years')
            
        ];
    }
}
