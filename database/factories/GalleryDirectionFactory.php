<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\GalleryDirection;

class GalleryDirectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GalleryDirection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_en' => $this->faker->word,
            'name_fr' => $this->faker->word,
            'description_en' => $this->faker->word,
            'description_fr' => $this->faker->word,
            'image' => $this->faker->word,
        ];
    }
}
