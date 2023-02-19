<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_en' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'title_fr' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'content_en' => $this->faker->text,
            'content_fr' => $this->faker->text,
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
