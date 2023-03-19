<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use Illuminate\Support\Str;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;

    public function definition()
    {
        
        return [
            'title' => $this->faker->text(67),
            'slug' => Str::slug('title','-'),
            'content' =>$this-> faker->text(67),
            'active' => $this->faker->boolean(),
        ];
    }
}
