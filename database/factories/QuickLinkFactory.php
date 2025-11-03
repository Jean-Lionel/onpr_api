<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\QuickLink;

class QuickLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuickLink::class;

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
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address_en' => $this->faker->word,
            'address_fr' => $this->faker->word,
            'box' => $this->faker->word,
        ];
    }
}
