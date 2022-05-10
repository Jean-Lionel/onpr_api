<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

                'title' => $this->faker->word(),
                'slug'  => $this->faker->name(),
                'body' => $this->faker->text(200),
                'image' => $this->faker->imageUrl($width = 640, $height = 480),
                'image_alt' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
                'user_id' => 1
        ];
    }
}
