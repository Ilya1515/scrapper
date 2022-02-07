<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $oldPrice = $this->faker->randomNumber(5, false);
        $price =  $this->faker->numberBetween(1000, $oldPrice - 100);
        return [
            'price' => $price,
            'old_price' => $oldPrice,
            'brand' => $this->faker->word(),
            'image' => Str::random(10),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(3),
            'url' => $this->faker->url()
        ];
    }
}